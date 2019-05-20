<?php

namespace App\SnackSale\Domain\Model\Snack;

use App\Support\Collection;

interface SnackRepository
{
    public function all(): Collection;
    public function save(Snack $snack);
}