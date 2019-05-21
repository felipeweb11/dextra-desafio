<?php

namespace App\SnackSale\Domain\Model\Snack;

use App\SnackSale\Domain\Model\Entity;
use App\SnackSale\Domain\Model\Snack\Ingredient\Ingredient;
use InvalidArgumentException;
use Money\Money;

class SnackIngredient extends Entity
{
    private $snack;
    private $ingredient;
    private $quantity;

    public function __construct(Ingredient $ingredient, int $quantity = 1)
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException('The amount of the ingredient must be greater than zero');
        }

        $this->ingredient = $ingredient;
        $this->quantity = $quantity;
    }

    public function getSnack()
    {
        return $this->snack;
    }

    public function setSnack($snack): void
    {
        $this->snack = $snack;
    }

    public function getIngredient(): Ingredient
    {
        return $this->ingredient;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getTotal(): Money
    {
        return Money::BRL($this->getIngredient()->getPrice() * $this->getQuantity() * 100);
    }
}