<?php

namespace App\Http\Api\Transformers;

use App\SnackSale\Domain\Model\Snack\Snack;
use App\SnackSale\Domain\Model\Snack\SnackPriceCalculator;
use League\Fractal;

class SnackTransformer extends Fractal\TransformerAbstract {

    protected $availableIncludes = [
        'ingredients'
    ];

    private $priceCalculator;

    public function __construct(SnackPriceCalculator $priceCalculator)
    {
        $this->priceCalculator = $priceCalculator;
    }

    public function transform(Snack $snack)
    {
        return [
            'id' => $snack->getId(),
            'name' => $snack->getName(),
            'image' => $snack->getImage(),
            'price' => formatMoney($this->priceCalculator->calcSalePrice($snack))
        ];
    }

    public function includeIngredients(Snack $snack)
    {
        return $this->collection($snack->getIngredients(), new SnackIngredientTransformer);
    }

}