<?php

namespace App\SnackSale\Domain\Model\Snack\Pricing\Calculators;
use App\SnackSale\Domain\Model\Snack\SnackIngredient;
use App\SnackSale\Domain\Model\Snack\SnackInterface;
use App\SnackSale\Domain\Model\Snack\SnackPriceCalculator;
use Money\Money;

class IngredientSumSnackPriceCalculator implements SnackPriceCalculator
{
    public function calcSalePrice(SnackInterface $snack): Money
    {
        return $snack->getIngredients()->reduce(function(Money $price, SnackIngredient $snackIngredient) {
            $ingredientSum = $snackIngredient->getIngredient()->getPrice()->multiply($snackIngredient->getQuantity());
            return $price->add($ingredientSum);
        }, Money::BRL(0));
    }
}