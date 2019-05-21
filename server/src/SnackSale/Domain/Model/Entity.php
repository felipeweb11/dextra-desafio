<?php

namespace App\SnackSale\Domain\Model;

abstract class Entity
{
    protected $id;

    public function getId():? string
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
        return $this;
    }
}