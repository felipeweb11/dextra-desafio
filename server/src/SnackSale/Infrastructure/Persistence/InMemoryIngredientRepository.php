<?php

namespace App\SnackSale\Infrastructure\Persistence;

use App\SnackSale\Domain\Model\Snack\Ingredient\Ingredient;
use App\SnackSale\Domain\Model\Snack\Ingredient\IngredientRepository;
use App\Support\Collection;

class InMemoryIngredientRepository implements IngredientRepository
{
    use InMemoryStorage;

    public function find(string $id): Ingredient
    {
        return $this->storage->find($id);
    }

    public function all(): Collection
    {
        return $this->storage->all();
    }

    public function save(Ingredient $ingredient): Ingredient
    {
        return $this->storage->save($ingredient);
    }
}