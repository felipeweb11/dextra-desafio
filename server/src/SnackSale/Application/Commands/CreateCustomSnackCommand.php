<?php

namespace App\SnackSale\Application\Commands;

class CreateCustomSnackCommand
{
    public $customerId;

    public function __construct(string $customerId)
    {
        $this->customerId = $customerId;
    }
}