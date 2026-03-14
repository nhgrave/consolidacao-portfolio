<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\PortfolioController;
use App\Http\Controllers\External\AlphaController;
use App\Http\Controllers\External\BetaController;

// Internal API routes
Route::get('/v1/portfolio/{client_id}', [PortfolioController::class, 'show']);
Route::post('/v1/portfolio/{client_id}/report', [PortfolioController::class, 'report']);
Route::get('/v1/portfolio/{client_id}/report_status', [PortfolioController::class, 'reportStatus']);

// External API routes
Route::get('/external/alpha/investments', [AlphaController::class, 'investments']);
Route::get('/external/beta/portfolio/{id}', [BetaController::class, 'portfolio']);
