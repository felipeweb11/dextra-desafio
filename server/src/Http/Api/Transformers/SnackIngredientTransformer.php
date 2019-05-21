<?php

namespace App\Http\Api\Transformers;

use App\SnackSale\Domain\Model\Snack\SnackIngredient;
use League\Fractal;

class SnackIngredientTransformer extends Fractal\TransformerAbstract {

    public function transform(SnackIngredient $snackIngredient)
    {
        return [
            'id' => $snackIngredient->getIngredient()->getId(),
            'name' => $snackIngredient->getIngredient()->getName(),
            'price' => formatMoney($snackIngredient->getIngredient()->getPrice()),
            'quantity' => $snackIngredient->getQuantity()
        ];
    }
    
}