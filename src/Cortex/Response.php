<?php

namespace Axiom\Rivescript\Cortex;

class Response
{
	public $source;
	public $weight;

	public function __construct($source, $weight = 1)
	{
		$this->source = $source;
		$this->weight = $weight;
	}
}
