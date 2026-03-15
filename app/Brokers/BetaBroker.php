<?php

namespace App\Brokers;

use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use App\DTO\AssetDTO;
use App\Services\Calculators\TaxCalculator;

class BetaBroker
{
    public function key(): string
    {
        return 'beta';
    }

    public function name(): string
    {
        return 'Beta';
    }

    public function type(): string
    {
        return 'variable';
    }

    public function tax(): float
    {
        return 0.15;
    }

    public function request(Pool $pool, int $clientId)
    {
        $baseUrl = config('services.external_api.url');

        return $pool->as($this->key())->get($baseUrl."/api/external/beta/portfolio/{$clientId}");
    }

    public function map(Response $response): array
    {
        return collect($response->json('portfolio'))->map(function ($asset) {
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
