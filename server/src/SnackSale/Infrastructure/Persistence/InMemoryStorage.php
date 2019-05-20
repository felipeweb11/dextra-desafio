<?php

namespace App\SnackSale\Infrastructure\Persistence;

trait InMemoryStorage
{
    /**
     * @var InMemoryRepository
     */
    protected $storage;

    public function __construct(InMemoryRepository $storage)
    {
        $this->storage = $storage;
    }

    public function nextIdentity(): string
    {
        return $this->storage->nextIdentity();
    }
}