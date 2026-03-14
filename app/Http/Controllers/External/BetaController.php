<?php

namespace App\Http\Controllers\External;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BetaController extends Controller
{
    public function portfolio($id)
    {
        sleep(2);

        if (rand(1,10) === 1) {
            return response()->json([
                'error' => 'Internal server error'
            ], 500);
        }

        return response()->json([
            'portfolio' => [
                ['asset' => 'Ações', 'value' => 30000.00],
                ['asset' => 'FIIs', 'value' => 20000.00],
            ]
        ]);
    }
}
