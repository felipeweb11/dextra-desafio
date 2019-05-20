<?php

namespace App\SnackSale\Infrastructure\Persistence;

use App\SnackSale\Domain\Model\Snack\Promotion\Promotion;
use App\SnackSale\Domain\Model\Snack\Promotion\PromotionRepository;
use App\Support\Collection;

class InMemoryPromotionRepository implements PromotionRepository
{
    use InMemoryStorage;

    public function all(): Collection
    {
        return $this->storage->all();
    }

    public function save(Promotion $promotion): Promotion
    {
        return $this->storage->save($promotion);
    }
}