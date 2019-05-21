<?php

namespace App\SnackSale\Domain\Model\Snack\Concerns;

use App\SnackSale\Domain\Model\Snack\Ingredient\Ingredient;
use App\SnackSale\Domain\Model\Snack\SnackIngredient;
use App\Support\Collection;

trait HasIngredients
{
    /**
     * @var Collection
     */
    protected $ingredients;

    public function getIngredients(): Collection {
        return $this->ingredients;
    }

    public function setIngredients(Collection $ingredients) {
        foreach ($ingredients as $i) {
            $this->addIngredient($i->getIngredient(), $i->getQuantity());
        }
    }

    public function addIngredient(Ingredient $ingredient, int $quantity = 1) {
        if ($snackIngredient = $this->ingredients->get($ingredient->getId())) {
            $snackIngredient->setQuantity($snackIngredient->getQuantity() + $quantity);
            return $this;
        }

        $snackIngredient = new SnackIngredient($ingredient, $quantity);
        $snackIngredient->setSnack($this);
        $this->ingredients->put($ingredient->getId(), $snackIngredient);
        return $this;
    }

    public function removeIngredient(Ingredient $ingredient, int $quantity = 1) {
        if ($snackIngredient = $this->ingredients->get($ingredient->getId())) {
            $newQuantity = $snackIngredient->getQuantity() - $quantity;
            if ($newQuantity > 0) {
                $snackIngredient->setQuantity($newQuantity);
            } else {
                $this->ingredients->remove($ingredient->getId());
            }
        }
        return $this;
    }
}