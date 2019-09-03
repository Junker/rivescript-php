<?php

namespace Axiom\Rivescript\Cortex;

use Axiom\Collections\Collection;

class Parser
{
	/**
	 * @var Collection
	 */
	protected $commands;

	/**
	 * @var Collection
	 */
	protected $tags;

	/**
	 * @var Collection
	 */
	protected $triggers;


	const COMMANDS = [
		'RedirectCommand',
	    'ResponseCommand',
	    'TopicCommand',
	    'TriggerCommand',
	    'VariableCommand',
	    'VariablePersonCommand',
	    'VariableSubstituteCommand',
	    'VariableArrayCommand',
	];

	const TAGS = [
		'StarTag',
		'BotTag',
		'SetTag',
		'GetTag',
		'TopicTag',
		'RandomTag',
	];

	const TRIGGERS = [
		'ArrayTrigger',
		'OptionalTrigger',
		'AlternationTrigger',
		'WildcardTrigger',
	];


	/**
	 * Create a new Parser instance.
	 */
	public function __construct()
	{
	}

	/**
	 * Parse the trigger through the available tags.
	 *
	 * @param string $trigger
	 *
	 * @return string
	 */
	public function parseTriggerTags($trigger, $input)
	{
		foreach (self::TAGS as $class) {
			$class = "\\Axiom\\Rivescript\\Cortex\\Tags\\$class";
			$tagClass = new $class('trigger');

			$trigger = $tagClass->parse($trigger, $input);
		}

	    return mb_strtolower($trigger);
	}

	/**
	 * Parse the response through the available tags.
	 *
	 * @param string $response
	 *
	 * @return string
	 */
	public function parseResponseTags($response, $input)
	{
		foreach (self::TAGS as $class) {
	        $class = "\\Axiom\\Rivescript\\Cortex\\Tags\\$class";
	        $tagClass = new $class();

	        $response = $tagClass->parse($response, $input);
	    };

	    return $response;
	}


	/**
	 * Parse triggers to find a possible match.
	 *
	 * @param string $trigger
	 *
	 * @return bool
	 */
	public function parseTriggers($trigger, $input)
	{
	    $trigger = preg_quote($trigger);

	    foreach (self::TRIGGERS as $class) {
	        $triggerClass = "\\Axiom\\Rivescript\\Cortex\\Triggers\\$class";
	        $triggerClass = new $triggerClass();

	        $trigger = $triggerClass->parse($trigger, $input);
	    };
	    
	    return $trigger;
	}

	public function parseCommands($node, $currentCommand)
	{
		foreach (self::COMMANDS as $command) {
			$class = "\\Axiom\\Rivescript\\Cortex\\Commands\\$command";
			$commandClass = new $class();

			$result = $commandClass->parse($node, $currentCommand);

			if (isset($result['command']))
			    return $result['command'];
		}

		return false;
	}


}