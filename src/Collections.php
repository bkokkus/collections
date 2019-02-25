<?php declare(strict_types = 1);

namespace Chestnut;

class Collections implements \Iterator, \ArrayAccess, \Countable 
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

    public function add($value): self
    {
        $this->array[] = $value;
        return $this;
    }

    public function search($value)
    {
        return array_search($value, $this->array);
    }

    public function remove($value): self
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

    public function valid(): bool
    {
        return isset($this->array[$this->key()]);
    }

    public function merge(array $arr): self
    {
        return new static(array_merge($this->array, $arr));
    }

    public function chunk(int $size): self
    {
        return new static(array_chunk($this->array, $size, false));
    }

    public function toJson(bool $prettyPrint = true): string
    {
        if (!$prettyPrint) {
            return json_encode($this->array, JSON_UNESCAPED_UNICODE);
        }

        return json_encode($this->array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function __toString()
    {
        return $this->toJson(false);
    }

    public function offsetSet($offset, $value)
    {
        if(is_null($offset)) {
            $this->array[] = $value;
        } else {
            $this->array[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->array[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->array[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->array[$offset]) ? $this->array[$offset] : null;
    }

    public function count(): int
    {
        return count($this->array);
    }

    public function get($key)
    {
        return $this[$key];
    }

    public function set($key, $value): void
    {
        $this[$key] = $value;
    }

    public function map(callable $callable): self
    {
    	return new static(array_map($callable, $this->array));
    }

    public function diff(Array $array): self
    {
    	return new static(array_diff($this->array, $array));
    }
    
    public function flip(): self
    {
    	return new static(array_flip($this->array));
    }

    public function intersect(Array $array): self
    {
    	return new static(array_intersect($this->array, $array));
    }

    public function intersectAssoc(Array $array): self
    {
    	return new static(array_intersect_assoc($this->array, $array));
    }

    public function intersectKey(Array $array): self
    {
    	return new static(array_intersect_key($this->array, $array));
    }

    public function shuffle(): bool
    {
    	shuffle($this->array);

    	return $this;
    }

    public function reverse($key = false): self 
    {
    	return new static(array_reverse($this->array, $key));
    }

    public function slice($offset, $length = null, $key = false): self
    {	
    	return new static(array_slice($this->array, $offset, $length, $key));
    }

    public function replace(Array $array, $recursively = false): self
    {    	
    	if(true === $recursively){
    		return new static(array_replace_recursive($this->array, $array));	
    	}

    	return new static(array_replace($this->array, $array));
    	
    }
}