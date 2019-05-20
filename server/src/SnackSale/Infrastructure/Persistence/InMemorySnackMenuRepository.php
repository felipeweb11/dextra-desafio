<?php

namespace App\SnackSale\Infrastructure\Persistence;
use App\SnackSale\Domain\Model\Snack\Menu\SnackMenu;
use App\SnackSale\Domain\Model\Snack\Menu\SnackMenuRepository;

class InMemorySnackMenuRepository implements SnackMenuRepository
{
    use InMemoryStorage;

    public function defaultMenu():? SnackMenu
    {
        return $this->storage->first();
    }

    public function save(SnackMenu $menu): SnackMenu
    {
        return $this->storage->save($menu);
    }
}