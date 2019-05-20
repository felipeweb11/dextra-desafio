<?php

namespace App\Http\Api\Transformers;

use App\SnackSale\Domain\Model\Snack\Menu\SnackIngredient;
use League\Fractal;

class SnacIngredientTransformer extends Fractal\TransformerAbstract {

    public function transform(SnackIngredient $snackIngredient)
    {
        return [
            'id' => $snackIngredient->getId(),
        ];
    }
    
}