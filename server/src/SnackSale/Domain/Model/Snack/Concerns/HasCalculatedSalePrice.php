<?php

namespace App\SnackSale\Domain\Model\Snack\Concerns;

use App\SnackSale\Domain\Model\Snack\SnackPriceCalculator;
use Money\Money;

trait HasCalculatedSalePrice
{
    public function calcSalePrice(SnackPriceCalculator $calculator): Money
    {
        return $calculator->calcSalePrice($this);
    }
}