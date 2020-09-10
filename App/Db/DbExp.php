<?php

namespace App\Db;

class DbExp
{
	protected $value;

	public function __construct(string $value)
	{
		$this->value = $value;
	}

	public function __toString()
	{
		return $this->value;
	}
}