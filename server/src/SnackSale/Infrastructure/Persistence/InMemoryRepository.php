<?php

namespace App\SnackSale\Infrastructure\Persistence;

use App\SnackSale\Domain\Model\Entity;
use App\Support\Collection;
use Ramsey\Uuid\Uuid;

class InMemoryRepository
{
    protected $models;

    public function __construct()
    {
        $this->models = new Collection;
    }

    public function all(): Collection {
        return $this->models;
    }

    public function first()
    {
        return $this->models->first();
    }

    public function find(string $id) {
        return $this->models->get($id);
    }

    public function save(Entity $model): Entity {
        if (! $model->getId()) {
            $model->setId($this->nextIdentity());
        }
        $this->models->put($model->getId(), $model);
        return $model;
    }

    public function nextIdentity(): string {
        return Uuid::uuid4();
    }
}