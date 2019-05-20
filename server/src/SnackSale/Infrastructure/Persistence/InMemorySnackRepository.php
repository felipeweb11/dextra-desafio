<?php

namespace App\SnackSale\Infrastructure\Persistence;

use App\SnackSale\Domain\Model\Snack\Snack;
use App\SnackSale\Domain\Model\Snack\SnackRepository;
use App\Support\Collection;

class InMemorySnackRepository implements SnackRepository
{
    use InMemoryStorage;

    public function all(): Collection
    {
        return $this->storage->all();
    }

    public function save(Snack $snack): Snack
    {
        return $this->storage->save($snack);
    }
}