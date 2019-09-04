<?php

namespace Axiom\Rivescript\Cortex;

class Trigger
{
	public $responses = [];

	public $conditions = [];

	public $source;
	public $type;
	public $order;
	public $redirect;

	public const TYPE_NUMERIC     = 'numeric';
	public const TYPE_ATOMIC      = 'atomic';
	public const TYPE_GLOBAL      = 'global';
	public const TYPE_ALPHABETIC  = 'alphabetic';


	public function __construct($source, $type)
	{
		$this->source = $source;
		$this->type = $type;
	} 
}