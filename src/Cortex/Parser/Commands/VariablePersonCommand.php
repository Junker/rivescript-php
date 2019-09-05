<?php

namespace Axiom\Rivescript\Cortex\Parser\Commands;

use Axiom\Rivescript\Contracts\Command;
use Axiom\Rivescript\Support\Str;

class VariablePersonCommand implements Command
{
    private $key;

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
        if ($node->command() === '!') {
            $type = strtok($node->value(), ' ');

            if ($type === 'person') {
                $value             = Str::replace($node->value(), 'person', '', 1);
                list($key, $value) = explode('=', $value);

                $key   = trim($key);
                $value = trim($value);

                $this->key = $key;

                synapse()->memory->person()->put($key, $value);

                return true;
            }
        }
    }

    public function addContinuation($str)
    {
        $value = synapse()->memory->person()->get($this->key);

        synapse()->memory->person()->put($this->key, $value.$str);
    }
}
