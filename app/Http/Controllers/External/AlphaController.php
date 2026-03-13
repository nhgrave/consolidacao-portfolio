<?php

namespace App\Http\Controllers\External;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlphaController extends Controller
{
    public function investments(Request $request)
    {
        return response()->json([
            'investments' => [
                ['asset' => 'CDB', 'value' => 50000.00],
                ['asset' => 'Tesouro', 'value' => 25000.00],
            ]
        ]);
    }
}
