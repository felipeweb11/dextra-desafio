<?php

namespace App\SnackSale\Domain\Model\Customer;

interface CustomerRepository
{
    public function find(string $id): Customer;
    public function save(Customer $customer): Customer;
}