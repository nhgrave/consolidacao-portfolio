<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\PortfolioService;

class PortfolioController extends Controller
{
    public function show(int $clientId, PortfolioService $service)
    {
        $portfolio = $service->getPortfolio($clientId);

        return response()->json($portfolio);
    }
}
