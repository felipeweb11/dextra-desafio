<?php

namespace App\SnackSale\Domain\Model\Snack\Promotion;

use App\Support\Collection;

interface PromotionRepository
{
    public function all(): Collection;
    public function save(Promotion $promotion): Promotion;
}