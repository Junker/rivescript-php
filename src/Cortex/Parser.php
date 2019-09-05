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
	    'ConditionCommand',
	    'TopicCommand',
	    'ContinueCommand',
	    'TriggerCommand',
	    'PreviousCommand',
	    'VariableCommand',
	    'VariablePersonCommand',
	    'VariableSubstituteCommand',
	    'VariableArrayCommand',
	];

	const TAGS = [
		'StarTag',
		'InputTag',
		'ReplyTag',
		'IdTag',
		'EolTag',
		'RandomTag',
		'BotTag',
		'PersonTag',
		'PersonStarTag',
		'FormalStarTag',
		'UppercaseStarTag',
		'LowercaseStarTag',
		'SentenceStarTag',
		'GetTag',
		'FormalTag',
		'UppercaseTag',
		'LowercaseTag',
		'SentenceTag',
		'SetTag',
		'TopicTag',
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
			$class = "\\Axiom\\Rivescript\\Cortex\\Parser\\Tags\\$class";
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
	        $class = "\\Axiom\\Rivescript\\Cortex\\Parser\\Tags\\$class";
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
	        $triggerClass = "\\Axiom\\Rivescript\\Cortex\\Parser\\Triggers\\$class";
	        $triggerClass = new $triggerClass();

	        $trigger = $triggerClass->parse($trigger, $input);
	    };
	    
	    return $trigger;
	}

	public function parseCommands($node)
	{
		foreach (self::COMMANDS as $command) {
			$class = "\\Axiom\\Rivescript\\Cortex\\Parser\\Commands\\$command";
			$commandClass = new $class();

			

			if ($commandClass->parse($node, null))
			{
				if (!$commandClass instanceof \Axiom\Rivescript\Cortex\Parser\Commands\ContinueCommand)
					synapse()->memory->shortTerm()->put('last_command', $commandClass);

				break;
			} 
		}

		return false;
	}


}