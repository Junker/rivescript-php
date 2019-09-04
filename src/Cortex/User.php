<?php

namespace Axiom\Rivescript\Cortex;

use Axiom\Collections\Collection;

class User
{
	public $variables;
	public $replies;
	public $inputs;

	public function __construct()
	{
	    $this->variables  = Collection::make([]);
	    $this->replies    = Collection::make([]);
	    $this->inputs     = Collection::make([]);
	    
	}
}