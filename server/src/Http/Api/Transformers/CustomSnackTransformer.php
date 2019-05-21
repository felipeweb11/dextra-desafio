<?php

namespace App\Http\Api\Transformers;

use App\SnackSale\Domain\Model\Snack\CustomSnack;
use App\SnackSale\Domain\Model\Snack\SnackPriceCalculator;
use League\Fractal;

class CustomSnackTransformer extends Fractal\TransformerAbstract {

    protected $defaultIncludes = [
        'ingredients'
    ];

    private $priceCalculator;

    public function __construct(SnackPriceCalculator $priceCalculator)
    {
        $this->priceCalculator = $priceCalculator;
    }

    public function transform(CustomSnack $customSnack)
    {
        return [
            'id' => $customSnack->getId(),
            'name' => $customSnack->getName(),
            'price' => formatMoney($this->priceCalculator->calcSalePrice($customSnack))
        ];
    }

    public function includeIngredients(CustomSnack $customSnack)
    {
        return $this->collection($customSnack->getIngredients(), new SnackIngredientTransformer);
    }

}