<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\Calculators\TaxCalculator;
use App\Services\Calculators\FeeCalculator;

class TaxCalculationTest extends TestCase
{
    public function test_fixed_income_tax_calculation(): void
    {
        $tax = TaxCalculator::calculate('fixed', 1000);

        $this->assertEquals(200, $tax);
    }

    public function test_variable_income_tax_calculation(): void
    {
        $tax = TaxCalculator::calculate('variable', 1000);

        $this->assertEquals(150, $tax);
    }

    public function test_consulting_fee_calculation(): void
    {
        $fee = FeeCalculator::calculate(1000);

        $this->assertEquals(5, $fee);
    }

    public function test_portfolio_asset_final_value_calculation(): void
    {
        $value = 1000;

        $tax = TaxCalculator::calculate('variable', $value);

        $afterTax = $value - $tax;

        $fee = FeeCalculator::calculate($afterTax);

        $net = $afterTax - $fee;

        $this->assertEquals(845.75, $net);
    }
}
