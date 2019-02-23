<?php

namespace Chestnut;

class Collections implements \Iterator
{
    protected $array;
    protected $position;

    public function __construct(array $arr = [])
    {
        $this->array = $arr;
        $this->position = 0;
    }

    public static function create(array $arr = []): self
    {
        return new static($arr);
    }

    public static function range($start, $end, $step = 1): self
    {
        return new static(range($start, $end, $step));
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

    public function rewind()
    {
        $this->position = 0;            
    }

    public function current()
    {
        return $this->array[$this->key()];
    }

    public function key()
    {
        return array_keys($this->array)[$this->position] ?? null;
    }

    public function next()
    {    
        $this->position++;        
    }

    public function valid()
    {
        return isset($this->array[$this->key()]);
    }
}