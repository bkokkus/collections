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
}