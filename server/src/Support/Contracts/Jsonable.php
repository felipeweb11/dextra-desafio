<?php

namespace App\Support\Contracts;

interface Jsonable
{
    public function toJson(int $options = 0): string;
}