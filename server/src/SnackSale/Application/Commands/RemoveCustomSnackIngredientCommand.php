<?php

namespace App\SnackSale\Application\Commands;

class RemoveCustomSnackIngredientCommand
{
    public $customSnackId;
    public $ingredientId;
    public $quantity;

    public function __construct(string $customSnackId, string $ingredientId, int $quantity = 1)
    {
        $this->customSnackId = $customSnackId;
        $this->ingredientId = $ingredientId;
        $this->quantity = $quantity;
    }
}