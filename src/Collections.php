<?php

namespace Chestnut;

class Collections
{
    protected $array;

    public function __construct(array $arr = [])
    {
        $this->array = $arr;
    }

    public static function create(array $arr = []): self
    {
        return new static($arr);
    }

    public function toArray(): array
    {
        return $this->array;
    }

    public function add($value)
    {
        $this->array[] = $value;
        return $this;
    }

    public function search($value)
    {
        return array_search($value, $this->array);
    }

    public function remove($value)
    {
        $key = $this->search($value);
        if($key !== false) {
            unset($this->array[$key]);
        }
        return $this;
    }

    public function first()
    {
        return reset($this->array);
    }

    public function last()
    {
        return end($this->array);
    }

}