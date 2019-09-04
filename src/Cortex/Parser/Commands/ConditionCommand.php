<?php

namespace Axiom\Rivescript\Cortex\Parser\Commands;

use Axiom\Rivescript\Contracts\Command;
use Axiom\Rivescript\Cortex\Condition;
use Axiom\Rivescript\Cortex\Response;

class ConditionCommand implements Command
{
    private $condition;

    const OPERATORS = [
        '==' => '==',
        'eq' => '==',
        '!=' => '!=',
        'ne' => '!=',
        '<>' => '!=',
        '<'  => '<',
        '<=' => '<=',
        '>'  => '>',
        '>=' => '>=',
    ];

    /**
     * Parse the command.
     *
     * @param Node   $node
     * @param string $command
     *
     * @return array
     */
    public function parse($node)
    {
        if ($node->command() === '*') {

            if ($node->value() == '/') return; //if comment

            $operator_aliases = array_keys(self::OPERATORS);
            $operators = array_unique(array_values(self::OPERATORS));

            $topic   = synapse()->memory->shortTerm()->get('topic') ?: 'random';
            $trigger = synapse()->memory->shortTerm()->get('trigger');

            list($condition, $response) = preg_split('/\s\=\>\s/', $node->value());

            foreach (self::OPERATORS as $alias => $operator) {
                $alias = preg_quote($alias);
                $condition = preg_replace('/\s+'.$alias.'\s+/', " $operator ", $condition);
            }

            foreach ($operators as $operator) {
                if (preg_match('/\s'.preg_quote($operator).'\s/', $condition)) {
                    list($variable1, $variable2) = preg_split('/\s'.preg_quote($operator).'\s/', $condition);

                    $this->condition = new Condition(trim($condition), trim($variable1), trim($variable2), trim($operator), new Response(trim($response)));

                    $trigger->conditions[] = $this->condition;

                    return true;
                }
            }
        }
    }

    public function addContinuation($str)
    {
        $this->condition->response->row .= $str;
    }
}
