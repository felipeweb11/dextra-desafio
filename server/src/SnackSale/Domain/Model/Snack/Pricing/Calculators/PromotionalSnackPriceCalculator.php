<?php

namespace App\SnackSale\Domain\Model\Snack\Pricing\Calculators;

use App\SnackSale\Domain\Model\Snack\Promotion\PromotionInterface;
use App\SnackSale\Domain\Model\Snack\SnackInterface;
use App\SnackSale\Domain\Model\Snack\SnackPriceCalculator;
use App\Support\Collection;
use Money\Money;

class PromotionalSnackPriceCalculator implements SnackPriceCalculator
{
    private $basePriceCalculator;
    private $promotions;

    public function __construct(SnackPriceCalculator $basePriceCalculator, Collection $promotions)
    {
        $this->basePriceCalculator = $basePriceCalculator;
        $this->promotions = $promotions;
    }

    public function calcSalePrice(SnackInterface $snack): Money
    {
        $basePrice = $this->basePriceCalculator->calcSalePrice($snack);
        $promotionalPrice = $this->promotions->reduce(function(Money $basePrice, PromotionInterface $promotion) use ($snack) {
            if ($promotion->contemplates($snack)) {
                return $basePrice->subtract($promotion->calcDiscount($snack, $basePrice));
            }
            return $basePrice;
        }, $basePrice);
        return $promotionalPrice;
    }
}