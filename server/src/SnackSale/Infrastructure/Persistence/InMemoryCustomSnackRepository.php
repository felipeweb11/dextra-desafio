<?php

namespace App\SnackSale\Infrastructure\Persistence;

use App\SnackSale\Domain\Model\Snack\CustomSnack;
use App\SnackSale\Domain\Model\Snack\CustomSnackRepository;

class InMemoryCustomSnackRepository implements CustomSnackRepository
{
    use InMemoryStorage;

    public function find(string $id): CustomSnack
    {
        return $this->storage->find($id);
    }

    public function save(CustomSnack $snack): CustomSnack
    {
        return $this->storage->save($snack);
    }
}