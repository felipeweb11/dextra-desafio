<?php

namespace App\SnackSale\Domain\Model\Customer;

use App\SnackSale\Domain\Model\Entity;
use App\SnackSale\Domain\Model\Snack\CustomSnack;
use App\Support\Collection;

class Customer extends Entity
{
    private $name;
    private $email;
    private $customSnacks;

    public function __construct(string $name, string $email)
    {
        $this->customSnacks = new Collection;
        $this->setName($name);
        $this->setEmail($email);
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function createCustomSnack(): CustomSnack {
        $snack = new CustomSnack($this);
        $this->customSnacks->push($snack);
        return $snack;
    }
}