<?php

namespace Axiom\Rivescript\Cortex;

use Axiom\Collections\Collection;

class User
{
	public $variables;
	public $replies;
	public $inputs;

	/**
     * current topic
     *
     * @var string
     */
	protected $topic = 'random';

	public function __construct()
	{
	    $this->variables  = Collection::make([]);
	    $this->replies    = Collection::make([]);
	    $this->inputs     = Collection::make([]);
	}

	public function topic()
	{
		return $this->topic;
	}

	public function setTopic($topic)
	{
		$this->topic = $topic;
	}
}
