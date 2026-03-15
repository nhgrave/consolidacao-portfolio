<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\PortfolioService;
use App\Services\PortfolioReportService;

class PortfolioController extends Controller
{
    public function show(int $clientId, PortfolioService $service)
    {
        $portfolio = $service->getPortfolio($clientId);

        return response()->json($portfolio);
    }

    public function generateReport(int $clientId, PortfolioReportService $service)
    {
        $report = $service->generateReport($clientId);

        return response()->json($report);
    }

    public function report(int $clientId, PortfolioReportService $service)
    {
        $report = $service->getReport($clientId);

        return response()->json($report);
    }
}
