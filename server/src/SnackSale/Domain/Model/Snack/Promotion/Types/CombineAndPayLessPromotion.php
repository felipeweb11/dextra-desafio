<?php

namespace App\SnackSale\Domain\Model\Snack\Promotion\Types;

use App\SnackSale\Domain\Model\Snack\Ingredient\Ingredient;
use App\SnackSale\Domain\Model\Snack\Promotion\Promotion;
use App\SnackSale\Domain\Model\Snack\Promotion\PromotionInterface;
use App\SnackSale\Domain\Model\Snack\SnackIngredient;
use App\SnackSale\Domain\Model\Snack\SnackInterface;
use App\Support\Collection;
use Exception;
use Money\Money;

class CombineAndPayLessPromotion extends Promotion implements PromotionInterface
{
    private $shouldContain;
    private $shouldNotContain;
    private $discountPercent;

    public function __construct(string $name, string $type)
    {
        parent::__construct($name, $type);
        $this->shouldContain = new Collection;
        $this->shouldNotContain = new Collection;
    }

    public function shouldContainIngredient(Ingredient $ingredient)
    {
        $this->shouldContain->push($ingredient->getId());
        return $this;
    }

    public function shouldNotContainIngredient(Ingredient $ingredient)
    {
        $this->shouldNotContain->push($ingredient->getId());
        return $this;
    }

    public function earnsDiscountPercentOf(float $discount)
    {
        $this->discountPercent = $discount;
        return $this;
    }

    public function contemplates(SnackInterface $snack): bool
    {
        $ingredientIds = $snack->getIngredients()->map(function (SnackIngredient $snackIngredient) {
            return $snackIngredient->getIngredient()->getId();
        });

        return $ingredientIds->intersect($this->shouldContain)->count() === $this->shouldContain->count() &&
               $ingredientIds->intersect($this->shouldNotContain)->count() === 0;
    }

    public function calcDiscount(SnackInterface $snack, Money $salePrice): Money
    {
        if (! $this->discountPercent) {
            throw new Exception('The discount percentage amount not is set');
        }

        return Money::BRL($salePrice->getAmount())
            ->multiply($this->discountPercent)
            ->divide(100);
    }
}