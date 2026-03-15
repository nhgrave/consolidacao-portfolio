<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use App\Brokers\AlphaBroker;
use App\Brokers\BetaBroker;
use App\DTO\PortfolioDTO;
use App\DTO\WarningDTO;
use App\Services\Calculators\FeeCalculator;

class PortfolioService
{
    private float $fee = 0.005;

    public function getPortfolio($clientId): PortfolioDTO
    {
        Log::info("Fetching portfolio", [
            'client_id' => $clientId,
        ]);

        $brokers = [
            new AlphaBroker(),
            new BetaBroker(),
        ];

        $responses = Http::pool(function ($pool) use ($brokers, $clientId) {
            $requests = [];

            foreach ($brokers as $broker) {
                $requests[$broker->key()] = $broker->request($pool, $clientId);
            }

            return $requests;
        });

        $portfolio = collect();
        $warnings = [];

        foreach ($brokers as $broker) {
            $response = $responses[$broker->key()];

            if ($response instanceof Response && $response->successful()) {
                $portfolio = $portfolio->merge($broker->map($response));

            } else if ($response instanceof \Throwable) {
                Log::error("API request failed", [
                    'service' => $broker->key(),
                    'message' => $response->getMessage(),
                    'trace' => $response->getTraceAsString(),
                ]);

                $warnings[] = new WarningDTO(
                    code: 'BROKER_UNAVAILABLE',
                    broker: $broker->key()
                );
            } else if ($response instanceof Response && $response->failed()) {
                Log::error("API returned error", [
                    'service' => $broker->key(),
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                $warnings[] = new WarningDTO(
                    code: 'BROKER_ERROR',
                    broker: $broker->key()
                );
            }
        }

        $total = collect($portfolio)->sum('value');
        $total_by_brokers = collect($portfolio)
            ->groupBy('broker')
            ->map(fn ($assets) => $assets->sum('value'))
            ->toArray();
        $tax = collect($portfolio)->sum('tax');

        $fee = FeeCalculator::calculate($total - $tax);

        return new PortfolioDTO(
            client_id: $clientId,
            portfolio: $portfolio->toArray(),
            resume: [
                'total' => $total,
                'total_by_brokers' => $total_by_brokers,
                'tax' => $tax,
                'fee' => $fee,
            ],
            warnings: $warnings
        );
    }
}
