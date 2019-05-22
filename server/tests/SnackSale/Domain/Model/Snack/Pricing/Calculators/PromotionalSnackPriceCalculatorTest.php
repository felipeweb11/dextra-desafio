<?php

namespace Tests\SnackSale\Domain\Model\Snack\Pricing\Calculators;

use App\SnackSale\Domain\Model\Snack\Ingredient\Ingredient;
use App\SnackSale\Domain\Model\Snack\Pricing\Calculators\IngredientSumSnackPriceCalculator;
use App\SnackSale\Domain\Model\Snack\Pricing\Calculators\PromotionalSnackPriceCalculator;
use App\SnackSale\Domain\Model\Snack\Promotion\Promotion;
use App\SnackSale\Domain\Model\Snack\Snack;
use App\SnackSale\Domain\Model\Snack\SnackIngredient;
use App\Support\Collection;
use Money\Money;
use Tests\TestCase;

class PromotionalSnackPriceCalculatorTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCalculatePromotionalPriceOfSnackBasedOnPromotions() {

        $lettuce = (new Ingredient('Alface', Money::BRL(40)))->setId(1);
        $bacon = (new Ingredient('Bacon', Money::BRL(200)))->setId(2);
        $beefBurger = (new Ingredient('Hambúrguer de Carne', Money::BRL(300)))->setId(3);
        $cheese = (new Ingredient('Queijo', Money::BRL(150)))->setId(4);

        $xBacon = new Snack('X-Bacon', new Collection([
            new SnackIngredient($bacon),
            new SnackIngredient($beefBurger),
            new SnackIngredient($cheese)
        ]));

        $xAlface = new Snack('X-Alface', new Collection([
            new SnackIngredient($lettuce),
            new SnackIngredient($cheese)
        ]));

        $xCheese = new Snack('X-Queijo', new Collection([
            new SnackIngredient($beefBurger),
            new SnackIngredient($cheese, 8)
        ]));

        $xBeef = new Snack('X-Carne', new Collection([
            new SnackIngredient($beefBurger, 3),
            new SnackIngredient($cheese, 4),
            new SnackIngredient($bacon)
        ]));

        $lightPromotion = Promotion::createCombineAndPayLessPromotion('Light')
            ->shouldContainIngredient($lettuce)
            ->shouldNotContainIngredient($bacon)
            ->earnsDiscountPercentOf(10);

        $muchCheese = Promotion::createTakeMorePayLessPromotion('Muito queijo')
            ->every(4)
            ->portionOfIngredient($cheese)
            ->customerPayFor(2);

        $muchBeef = Promotion::createTakeMorePayLessPromotion('Muita carne')
            ->every(3)
            ->portionOfIngredient($beefBurger)
            ->customerPayFor(2);

        $promotions = new Collection([$lightPromotion, $muchCheese, $muchBeef]);
        $ingredientCalculator = new IngredientSumSnackPriceCalculator;
        $promotionCalculator = new PromotionalSnackPriceCalculator($ingredientCalculator, $promotions);

        // Prices without promotion
        $this->assertEquals(Money::BRL(650), $ingredientCalculator->calcSalePrice($xBacon));
        $this->assertEquals(Money::BRL(190), $ingredientCalculator->calcSalePrice($xAlface));
        $this->assertEquals(Money::BRL(1500), $ingredientCalculator->calcSalePrice($xCheese));
        $this->assertEquals(Money::BRL(1700), $ingredientCalculator->calcSalePrice($xBeef));

        // X-Bacon is not covered by any promotion, then the price does not change
        $this->assertEquals(Money::BRL(650), $promotionCalculator->calcSalePrice($xBacon));

        // x-Alface is covered by "Light" promotion, then the price has a 10% discount
        $this->assertEquals(Money::BRL(171), $promotionCalculator->calcSalePrice($xAlface));

        // x-Cheese is covered by "Muito queijo" promotion, then the customer will pay for 4 portions
        $this->assertEquals(Money::BRL(900), $promotionCalculator->calcSalePrice($xCheese));

        // x-Beef is covered by "Muito queijo" and "Muita carne" promotion, then the customer will
        // pay for 2 portions of cheese and 2 portions of beef
        $this->assertEquals(Money::BRL(1100), $promotionCalculator->calcSalePrice($xBeef));
    }

}