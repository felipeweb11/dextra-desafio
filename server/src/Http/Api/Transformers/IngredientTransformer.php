<?php

namespace App\Http\Api\Transformers;

use App\SnackSale\Domain\Model\Snack\Ingredient\Ingredient;
use League\Fractal;

class IngredientTransformer extends Fractal\TransformerAbstract {

    public function transform(Ingredient $ingredient)
    {
        return [
            'id' => $ingredient->getId(),
            'name' => $ingredient->getName(),
            'image' => $ingredient->getImage(),
            'price' => formatMoney($ingredient->getPrice()),
        ];
    }
}