<?php

namespace App\SnackSale\Domain\Model\Snack;

use App\SnackSale\Domain\Model\Snack\Ingredient\Ingredient;
use App\Support\Collection;
use App\Support\Contracts\Arrayable;
use Money\Money;

interface SnackInterface extends Arrayable
{
    public function getName();
    public function getIngredients(): Collection;
    public function addIngredient(Ingredient $ingredient, int $quantity = 1);
    public function removeIngredient(Ingredient $ingredient);
    public function calcSalePrice(SnackPriceCalculator $calculator): Money;
}