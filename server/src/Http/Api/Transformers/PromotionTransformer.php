<?php

namespace App\Http\Api\Transformers;

use App\SnackSale\Domain\Model\Snack\Promotion\Promotion;
use League\Fractal;

class PromotionTransformer extends Fractal\TransformerAbstract {

    public function transform(Promotion $promotion)
    {
        return [
            'id' => $promotion->getId(),
            'name' => $promotion->getName(),
            'description' => $promotion->getDescription()
        ];
    }
}