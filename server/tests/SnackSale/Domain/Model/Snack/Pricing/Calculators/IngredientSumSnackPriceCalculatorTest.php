<?php

namespace Tests\SnackSale\Domain\Model\Snack\Pricing\Calculators;

use App\SnackSale\Domain\Model\Snack\Ingredient\Ingredient;
use App\SnackSale\Domain\Model\Snack\Pricing\Calculators\IngredientSumSnackPriceCalculator;
use App\SnackSale\Domain\Model\Snack\Snack;
use App\SnackSale\Domain\Model\Snack\SnackIngredient;
use App\Support\Collection;
use Money\Money;
use Tests\TestCase;

class IngredientSumSnackPriceCalculatorTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCalculatePriceOfSnackBasedOnSumOfTheIngredientsContained() {
        $bacon = (new Ingredient('Bacon', Money::BRL(200)))->setId(1);
        $beefBurger = (new Ingredient('Hambúrguer de Carne', Money::BRL(300)))->setId(2);
        $egg = (new Ingredient('Ovo', Money::BRL(80)))->setId(3);
        $cheese = (new Ingredient('Queijo', Money::BRL(150)))->setId(4);

        $snacks = [
            new Snack('X-Bacon', new Collection([
                new SnackIngredient($bacon),
                new SnackIngredient($beefBurger),
                new SnackIngredient($cheese)
            ])),
            new Snack('X-Burger', new Collection([
                new SnackIngredient($beefBurger),
                new SnackIngredient($cheese, 3)
            ])),
            new Snack('X-Egg', new Collection([
                new SnackIngredient($egg),
                new SnackIngredient($beefBurger),
                new SnackIngredient($cheese)
            ])),
            new Snack('X-Egg-Bacon', new Collection([
                new SnackIngredient($egg),
                new SnackIngredient($bacon),
                new SnackIngredient($beefBurger),
                new SnackIngredient($cheese)
            ])),
        ];

        $expectedPrices = [Money::BRL(650), Money::BRL(750), Money::BRL(530), Money::BRL(730)];

        $calculator = new IngredientSumSnackPriceCalculator;

        foreach ($snacks as $key => $snack) {
            $this->assertEquals($expectedPrices[$key], $calculator->calcSalePrice($snack));
        }

    }

}