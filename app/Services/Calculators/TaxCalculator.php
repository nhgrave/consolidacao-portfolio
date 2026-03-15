<?php

namespace App\Services\Calculators;

class TaxCalculator
{
    const FIXED_INCOME_TAX = 0.20;
    const VARIABLE_INCOME_TAX = 0.15;

    public static function calculate(string $type, float $value): float
    {
        $rate = match ($type) {
            'fixed' => self::FIXED_INCOME_TAX,
            'variable' => self::VARIABLE_INCOME_TAX,
            default => 0
        };

        return $value * $rate;
    }
}
