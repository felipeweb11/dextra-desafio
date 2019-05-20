<?php

namespace App\SnackSale\Domain\Model\Snack;

use Money\Money;

interface SnackPriceCalculator
{
    public function calcSalePrice(SnackInterface $snack): Money;
}