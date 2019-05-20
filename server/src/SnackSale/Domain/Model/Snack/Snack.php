<?php

namespace App\SnackSale\Domain\Model\Snack;

use App\SnackSale\Domain\Model\Entity;
use App\SnackSale\Domain\Model\Snack\Concerns\HasCalculatedSalePrice;
use App\SnackSale\Domain\Model\Snack\Concerns\HasIngredients;
use App\Support\Collection;

class Snack extends Entity implements SnackInterface
{
    use HasIngredients, HasCalculatedSalePrice;

    private $name;

    public function __construct(string $name, Collection $ingredients = null)
    {
        $this->name = $name;
        $this->ingredients = new Collection;
        if ($ingredients) {
            $this->setIngredients($ingredients);
        }
    }

    public function getName() {
        return $this->name;
    }

    public function setName(string $newName) {
        $this->name = $newName;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'ingredients' => $this->getIngredients()->toArray()
        ];
    }
}