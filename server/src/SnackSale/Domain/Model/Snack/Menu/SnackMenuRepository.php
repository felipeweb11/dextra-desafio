<?php

namespace App\SnackSale\Domain\Model\Snack\Menu;

interface SnackMenuRepository
{
    public function defaultMenu():? SnackMenu;
    public function save(SnackMenu $menu): SnackMenu;
}