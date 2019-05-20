<?php

namespace App\SnackSale\Domain\Model;

use App\Support\Contracts\Arrayable;
use App\Support\Contracts\Jsonable;

abstract class Entity implements Arrayable, Jsonable
{
    protected $id;

    /**
     * @return string
     */
    public function getId():? string
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
        return $this;
    }

    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

}