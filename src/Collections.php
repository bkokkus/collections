<?php 

namespace Chestnut;

class Collections
{
    protected $array;

    public function __construct(array $arr = [])
    {
        $this->array = $arr;
    }

    public function toArray(): array
    {
        return $this->array;
    }

    public function add($key)
    {
        $this->array[] = $key;
        return $this;
    }

}