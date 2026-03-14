<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Services\PortfolioService;
use App\Models\Report;

class GeneratePortfolioReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $reportId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $reportId)
    {
        $this->reportId = $reportId;
    }

    /**
     * Execute the job.
     */
    public function handle(PortfolioService $portfolioService): void
    {
        Log::info("Start processing report", [
            'report_id' => $this->reportId,
        ]);

        $report = Report::findOrFail($this->reportId);

        sleep(5);

        $report->update([
            'status' => 'processing'
        ]);

        sleep(5);

        try {
            $portfolio = $portfolioService->getPortfolio($report->client_id);

            $warnings = collect($portfolio->warnings);

            if ($warnings->isNotEmpty()) {
                throw new \Exception("Warnings found: " . $warnings->pluck('code')->join(', '));
            }

            $report->update([
                'status' => 'completed',
                'total' => $portfolio->resume['total'],
                'tax' => $portfolio->resume['tax'],
                'fee' => $portfolio->resume['fee'],
            ]);

            Log::info("Report generated successfully", [
                'report_id' => $report->id,
            ]);
        } catch (\Throwable $e) {
            Log::error("Failed to generate report", [
                'report_id' => $report->id,
                'error' => $e->getMessage()
            ]);

            $report->update([
                'status' => 'failed'
            ]);
        }
    }
}
