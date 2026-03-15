<?php

namespace App\Services\Calculators;

class FeeCalculator
{
    const CONSULTING_FEE = 0.005;

    public static function calculate(float $valueAfterTax): float
    {
        return $valueAfterTax * self::CONSULTING_FEE;
    }
}
