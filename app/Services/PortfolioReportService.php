<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use App\Models\Report;
use App\Jobs\GeneratePortfolioReport;

class PortfolioReportService
{
    public function generateReport($clientId): array
    {
        Log::info("Generate report for client", [
            'client_id' => $clientId,
        ]);

        $report = Report::create([
            'client_id' => $clientId,
            'status' => 'pending'
        ]);

        GeneratePortfolioReport::dispatch($report->id);

        return [
            'report_id' => $report->id,
            'status' => $report->status,
        ];
    }

    public function getReport($clientId): ?Report
    {
        $report = Report::where('client_id', $clientId)->latest()->first();

        if (!$report) {
            return null;
        }

        return $report;
    }
}
