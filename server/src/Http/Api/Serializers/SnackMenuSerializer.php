<?php

namespace App\Http\Api\Serializers;

use App\SnackSale\Domain\Model\Snack\Menu\SnackMenu;
use App\SnackSale\Domain\Model\Snack\Snack;
use App\SnackSale\Domain\Model\Snack\SnackPriceCalculator;

class SnackMenuSerializer
{
    private $priceCalculator;

    public function __construct(SnackPriceCalculator $priceCalculator)
    {
        $this->priceCalculator = $priceCalculator;
    }

    public function serialize(SnackMenu $menu): string
    {
        $snacks = $menu->getSnacks()->map(function(Snack $snack) {
            return array_merge($snack->toArray(), [
                'price' => $snack->calcSalePrice($this->priceCalculator)
            ]);
        })->toArray();

        return json_encode(array_merge($menu->toArray(), compact('snacks')));
    }
}