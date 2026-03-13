<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use App\DTO\AssetDTO;
use App\DTO\PortfolioDTO;

class PortfolioService
{
    public function getPortfolio($clientId): PortfolioDTO
    {
        Log::info("Fetching portfolio", [
            'client_id' => $clientId,
        ]);

        $baseUrl = config('services.api_base.url');

        $responses = Http::pool(function ($pool) use ($clientId, $baseUrl) {
            return [
                $pool->as('alpha')->get(
                    "{$baseUrl}/external/alpha/investments",
                    ['client_id' => $clientId]
                ),

                $pool->as('beta')->get(
                    "{$baseUrl}/external/beta/portfolio/{$clientId}"
                ),
            ];
        });

        foreach ($responses as $key => $response) {
            if ($response instanceof \Throwable) {
                Log::error("API request failed", [
                    'service' => $key,
                    'message' => $response->getMessage(),
                    'trace' => $response->getTraceAsString(),
                ]);
            }

            if ($response instanceof Response && $response->failed()) {
                Log::error("API returned error", [
                    'service' => $key,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        }

        $portfolio = [];
        $alphaResponse = $responses['alpha'];
        $betaResponse = $responses['beta'];

        // ativos da Alpha
        if ($alphaResponse instanceof Response && $alphaResponse->successful()) {
            foreach ($alphaResponse->json('investments') as $investment) {
                $portfolio[] = $this->mapToAssetDTO(
                    investment: $investment,
                    broker: 'Alpha',
                    type: 'fixed',
                    tax: 0.20
                );
            }
        }

        // ativos da Beta
        if ($betaResponse instanceof Response && $betaResponse->successful()) {
            foreach ($betaResponse->json('portfolio') as $investment) {
                $portfolio[] = $this->mapToAssetDTO(
                    investment: $investment,
                    broker: 'Beta',
                    type: 'variable',
                    tax: 0.15
                );
            }
        }

        $total = array_sum(array_map(fn ($asset) => $asset->value, $portfolio));
        $tax = array_sum(array_map(fn ($asset) => $asset->tax, $portfolio));

        return new PortfolioDTO(
            client_id: $clientId,
            portfolio: $portfolio,
            resume: [
                'total' => $total,
                'tax' => $tax,
                'fee' => ($total - $tax) * 0.005,
            ],
        );
    }

    private function mapToAssetDTO(array $investment, string $broker, string $type, float $tax): AssetDTO
    {
        return new AssetDTO(
            asset: $investment['asset'],
            type: $type,
            broker: $broker,
            tax: $investment['value'] * $tax,
            value: $investment['value']
        );
    }
}
