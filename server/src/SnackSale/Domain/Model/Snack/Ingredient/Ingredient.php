<?php

namespace App\SnackSale\Domain\Model\Snack\Ingredient;

use App\SnackSale\Domain\Model\Entity;
use Money\Money;

class Ingredient extends Entity
{
    private $name;
    private $price;

    public function __construct(string $name, Money $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $newName) {
        $this->name = $newName;
    }

    public function getPrice(): Money {
        return $this->price;
    }

    public function setPrice(Money $newPrice) {
        $this->price = $newPrice;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
        ];
    }
}