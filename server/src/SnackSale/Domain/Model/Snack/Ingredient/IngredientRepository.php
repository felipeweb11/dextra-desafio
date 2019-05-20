<?php

namespace App\SnackSale\Domain\Model\Snack\Ingredient;

use App\Support\Collection;

interface IngredientRepository
{
    public function find(string $id): Ingredient;
    public function all(): Collection;
    public function save(Ingredient $ingredient): Ingredient;
}