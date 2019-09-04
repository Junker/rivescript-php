<?php

namespace Axiom\Rivescript\Cortex;

class Response
{
	public $row;
	public $weight;

	public function __construct($row, $weight = 1)
	{
		$this->row = $row;
		$this->weight = $weight;
	}
}
