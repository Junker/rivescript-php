<?php

namespace Axiom\Rivescript\Cortex\Parser\Commands;

use Axiom\Rivescript\Contracts\Command;

class VariablePersonCommand implements Command
{
    /**
     * Parse the command.
     *
     * @param Node   $node
     * @param string $command
     *
     * @return array
     */
    public function parse($node, $command)
    {
        if ($node->command() === '!') {
            $type = strtok($node->value(), ' ');

            if ($type === 'person') {
                $value             = str_replace('person', '', $node->value());
                list($key, $value) = explode('=', $value);

                $key   = trim($key);
                $key   = '/\b'.preg_quote($key, '/').'\b/'; // Convert the "key" to a regular expression ready format
                $value = trim($value);

                synapse()->memory->person()->put($key, $value);
            }
        }
    }
}
