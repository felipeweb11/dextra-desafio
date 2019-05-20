<?php

namespace App\SnackSale\Domain\Model\Snack;

interface CustomSnackRepository
{
    public function find(string $id): CustomSnack;
    public function save(CustomSnack $snack): CustomSnack;
}