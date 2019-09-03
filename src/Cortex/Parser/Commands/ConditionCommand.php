<?php

namespace Axiom\Rivescript\Cortex\Parser\Commands;

use Axiom\Rivescript\Contracts\Command;
use Axiom\Rivescript\Cortex\Condition;

class ConditionCommand implements Command
{
    /**
     * Parse the command.
     *
     * @param Node   $node
     * @param string $command
     *
     * @return array
     */

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

    public function parse($node, $command)
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

                    $trigger->conditions[] = new Condition(trim($condition), trim($variable1), trim($variable2), trim($operator), trim($response));

                    return;
                }
            }
        }
    }
}
