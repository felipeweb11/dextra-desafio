<?php

namespace App\Http\Api\Transformers;

use App\SnackSale\Domain\Model\Snack\Menu\SnackMenu;
use League\Fractal;

class SnackMenuTransformer extends Fractal\TransformerAbstract {

    protected $defaultIncludes = [
      'snacks'
    ];
  
    public function transform(SnackMenu $menu)
    {
        return [
            'id' => $menu->getId(),
            'name' => $menu->getName()
        ];
    }

    public function includeSnacks(SnackMenu $menu)
    {
        return $this->collection($menu->getSnacks(), new SnackTransformer);
    }

}