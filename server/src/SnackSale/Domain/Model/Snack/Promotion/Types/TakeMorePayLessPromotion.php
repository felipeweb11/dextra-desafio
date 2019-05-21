<?php

namespace App\SnackSale\Domain\Model\Snack\Promotion\Types;

use App\SnackSale\Domain\Model\Snack\Ingredient\Ingredient;
use App\SnackSale\Domain\Model\Snack\Promotion\Promotion;
use App\SnackSale\Domain\Model\Snack\Promotion\PromotionInterface;
use App\SnackSale\Domain\Model\Snack\SnackInterface;
use Exception;
use Money\Money;

class TakeMorePayLessPromotion extends Promotion implements PromotionInterface
{
    /**
     * @var Ingredient
     */
    private $ingredient;
    private $occurrenceNumber;
    private $customerPayFor;

    public function every(int $occurrenceNumber)
    {
        $this->occurrenceNumber = $occurrenceNumber;
        return $this;
    }

    public function portionOfIngredient(Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;
        return $this;
    }

    public function customerPayFor(int $quantity)
    {
        if ($quantity < 0) {
            throw new Exception('The number of portions that the customer will pay can not be less than zero');
        }

        if ($quantity >= $this->occurrenceNumber) {
            throw new Exception('The number of portions that the customer will pay can not be greater or equals than number of portions occurrence');
        }

        $this->customerPayFor = $quantity;
        return $this;
    }

    public function contemplates(SnackInterface $snack): bool
    {
        if (is_null($this->ingredient) || is_null($this->occurrenceNumber) || is_null($this->customerPayFor)) {
            return false;
        }

        $snackIngredient = $snack->getIngredients()->get($this->ingredient->getId());
        return $snackIngredient ?
            intdiv($snackIngredient->getQuantity(), $this->occurrenceNumber) > 0 :
            false;
    }

    public function calcDiscount(SnackInterface $snack, Money $salePrice): Money
    {
        if (is_null($this->ingredient)) {
            throw new Exception('The ingredient not is set');
        }

        if (is_null($this->occurrenceNumber)) {
            throw new Exception('The occurrence number of ingredient not is set');
        }

        if (is_null($this->customerPayFor)) {
            throw new Exception('The number of portions that the customer will pay has not been defined');
        }

        $snackIngredient = $snack->getIngredients()->get($this->ingredient->getId());

        if (! $snackIngredient) {
            return Money::BRL(0);
        }

        $matches = intdiv($snackIngredient->getQuantity(), $this->occurrenceNumber);
        $quantityToPay = $matches * $this->customerPayFor + ceil(($snackIngredient->getQuantity() % $this->occurrenceNumber));
        $discountCount = $snackIngredient->getQuantity() - $quantityToPay;
        return $snackIngredient->getIngredient()->getPrice()->multiply($discountCount);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'ingredient' => $this->ingredient,
            'occurrence_number' => $this->occurrenceNumber,
            'customer_pay_for' => $this->customerPayFor,
        ]);
    }
}