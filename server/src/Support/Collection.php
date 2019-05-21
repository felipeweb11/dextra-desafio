<?php

namespace App\Support;

use ArrayIterator;
use IteratorAggregate;

class Collection implements IteratorAggregate
{
    private $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function all(): array {
        return $this->items;
    }

    public function first()
    {
        $key = array_key_first($this->items);
        return $key ? $this->items[$key] : null;
    }

    public function push($item) {
        $this->items[] = $item;
        return $this;
    }

    public function get($key)
    {
        return $this->has($key) ? $this->items[$key] : null;
    }

    public function has($key)
    {
        return isset($this->items[$key]);
    }

    public function put($key, $value)
    {
        $this->items[$key] = $value;
        return $this;
    }

    public function remove($key) {
        unset($this->items[$key]);
    }

    public function map(callable $callback)
    {
        $keys = array_keys($this->items);
        $items = array_map($callback, $this->items, $keys);
        return new static(array_combine($keys, $items));
    }

    public function reduce(callable $callback, $initial = null)
    {
        return array_reduce($this->items, $callback, $initial);
    }

    public function some(callable $callback): bool
    {
       return true;
    }

    public function filter(callable $callback)
    {
        $items = array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH);
        return new static($items);
    }

    public function count()
    {
        return count($this->items);
    }

    public function intersect(Collection $other)
    {
        return new static(array_intersect($this->items, $other->items));
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }
}