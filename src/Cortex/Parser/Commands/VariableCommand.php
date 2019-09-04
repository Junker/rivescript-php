<?php

namespace Axiom\Rivescript\Cortex\Parser\Commands;

use Axiom\Rivescript\Contracts\Command;
use Axiom\Rivescript\Support\Str;

class VariableCommand implements Command
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

            if ($type === 'var') {
                $value             = Str::replace($node->value(), 'var', '', 1);
                list($key, $value) = explode('=', $value);

                $key   = trim($key);
                $value = trim($value);

                $this->key = $key;

                synapse()->memory->variables()->put($key, $value);

                return true;
            }
        }
    }

    public function addContinuation($str)
    {
        $value = synapse()->memory->variables()->get($this->key);

        synapse()->memory->variables()->put($this->key, $value.$str);
    }
}
