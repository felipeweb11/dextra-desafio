<?php

namespace App\SnackSale\Domain\Model\Snack\Ingredient;

use App\SnackSale\Domain\Model\Entity;
use Money\Money;

class Ingredient extends Entity
{
    private $name;
    private $price;
    private $image;

    public function __construct(string $name, Money $price, string $image = null)
    {
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
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

    public function getImage():? string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }
}