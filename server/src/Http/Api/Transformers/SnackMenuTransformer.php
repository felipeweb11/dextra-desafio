<?php

namespace App\Http\Api\Transformers;

use App\SnackSale\Domain\Model\Snack\Menu\SnackMenu;
use Psr\Container\ContainerInterface;
use League\Fractal;

class SnackMenuTransformer extends Fractal\TransformerAbstract {

    protected $defaultIncludes = [
      'snacks'
    ];

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
  
    public function transform(SnackMenu $menu)
    {
        return [
            'id' => $menu->getId(),
            'name' => $menu->getName()
        ];
    }

    public function includeSnacks(SnackMenu $menu)
    {
        return $this->collection($menu->getSnacks(), $this->container->get(SnackTransformer::class));
    }

}