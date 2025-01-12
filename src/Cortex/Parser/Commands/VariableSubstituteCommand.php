<?php

namespace Axiom\Rivescript\Cortex\Parser\Commands;

use Axiom\Rivescript\Contracts\Command;
use Axiom\Rivescript\Support\Str;

class VariableSubstituteCommand implements Command
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

            if ($type === 'sub') {
                $value             = Str::replace($node->value(), 'sub', '', 1);
                list($key, $value) = explode('=', $value);

                $key   = trim($key);
                $key   = '/\b'.preg_quote($key, '/').'\b/'; // Convert the "key" to a regular expression ready format
                $value = trim($value);

                $this->key = $key;

                synapse()->memory->substitute()->put($key, $value);

                return true;
            }
        }
    }

    public function addContinuation($str)
    {
        $value = synapse()->memory->substitute()->get($this->key);

        synapse()->memory->substitute()->put($this->key, $value.$str);
    }
}
