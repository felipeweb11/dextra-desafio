<?php

namespace App\SnackSale\Infrastructure\Persistence;

use App\SnackSale\Domain\Model\Customer\Customer;
use App\SnackSale\Domain\Model\Customer\CustomerRepository;

class InMemoryCustomerRepository implements CustomerRepository
{
    use InMemoryStorage;

    public function find(string $id): Customer
    {
        return $this->storage->find($id);
    }

    public function save(Customer $customer): Customer
    {
        return $this->storage->save($customer);
    }
}