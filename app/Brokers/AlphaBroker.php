<?php

namespace App\Brokers;

use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use App\DTO\AssetDTO;
use App\Services\Calculators\TaxCalculator;

class AlphaBroker
{
    public function key(): string
    {
        return 'alpha';
    }

    public function name(): string
    {
        return 'Alpha';
    }

    public function type(): string
    {
        return 'fixed';
    }

    public function tax(): float
    {
        return 0.2;
    }

    public function request(Pool $pool, int $clientId)
    {
        $baseUrl = config('services.external_api.url');

        return $pool->as($this->key())->get($baseUrl."/api/external/alpha/investments?client_id={$clientId}");
    }

    public function map(Response $response): array
    {
        return collect($response->json('investments'))->map(function ($asset) {
            $tax = TaxCalculator::calculate($this->type(), $asset['value']);

            return new AssetDTO(
                asset: $asset['asset'],
                type: $this->type(),
                broker: $this->name(),
                value: $asset['value'],
                tax: $tax,
            );
        })->toArray();
    }
}
