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

    public function report(int $clientId, PortfolioReportService $service)
    {
        $report = $service->generateReport($clientId);

        return response()->json($report);
    }

    public function reportStatus(int $clientId, PortfolioReportService $service)
    {
        $status = $service->getReportStatus($clientId);

        return response()->json(['status' => $status]);
    }
}
