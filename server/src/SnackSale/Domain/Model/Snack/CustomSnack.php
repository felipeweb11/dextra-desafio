<?php

namespace App\SnackSale\Domain\Model\Snack;

use App\SnackSale\Domain\Model\Customer\Customer;
use App\SnackSale\Domain\Model\Entity;
use App\SnackSale\Domain\Model\Snack\Concerns\HasCalculatedSalePrice;
use App\SnackSale\Domain\Model\Snack\Concerns\HasIngredients;
use App\Support\Collection;

class CustomSnack extends Entity implements SnackInterface
{
    use HasIngredients, HasCalculatedSalePrice;

    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
        $this->ingredients = new Collection;
    }

    public function getName()
    {
        return 'Lanche customizado';
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'customer' => $this->getCustomer()->toArray(),
            'ingredients' => $this->getIngredients()->toArray()
        ];
    }
}