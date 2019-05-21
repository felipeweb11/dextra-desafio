<?php

namespace App\SnackSale\Domain\Model\Snack\Menu;

use App\SnackSale\Domain\Model\Entity;
use App\Support\Collection;

class SnackMenu extends Entity
{
    private $name;
    private $snacks;

    public function __construct(string $name, Collection $snacks)
    {
        $this->name = $name;
        $this->snacks = $snacks;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSnacks()
    {
        return $this->snacks;
    }
}