<?php

namespace Axiom\Rivescript\Cortex;

class Condition
{
	public $source;
	public $variable1;
	public $variable2;
	public $operator;
	public $responce;

	public function __construct(string $source, string $variable1, string $variable2, string $operator, Response $response)
	{
		$this->source = $source;
		$this->variable1 = $variable1;
		$this->variable2 = $variable2;
		$this->operator = $operator;
		$this->response = $response;
	}


	public function assert($input)
	{
        $var1 = synapse()->parser->parseResponseTags($this->variable1, $input);
        $var2 = synapse()->parser->parseResponseTags($this->variable2, $input);

        return eval(sprintf("return '%s' %s '%s';", addslashes($var1), $this->operator, addslashes($var2)));
	}

}
	