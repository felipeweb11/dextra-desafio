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
    private $image;

    public function __construct(string $name, Collection $ingredients = null, string $image = null)
    {
        $this->name = $name;
        $this->image = $image;
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

    public function getImage():? string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

}