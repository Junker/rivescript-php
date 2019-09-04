<?php

namespace Axiom\Rivescript\Cortex\Parser\Commands;

use Axiom\Rivescript\Contracts\Command;
use Axiom\Rivescript\Support\Str;

class VariableArrayCommand implements Command
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

            if ($type === 'array') {
                $value             = Str::replace($node->value(), 'array', '', 1);
                list($key, $value) = explode('=', $value);

                $key   = trim($key);
                $value = trim($value);

                $value = explode(strpos($value, '|') ? '|' : ' ', $value);

                $this->key = $key;

                synapse()->memory->arrays()->put($key, $value);

                return true;
            }
        }
    }

    public function addContinuation($str)
    {
        $value = synapse()->memory->arrays()->get($this->key);

        $str = trim($str);

        $arr = explode(strpos($str, '|') ? '|' : ' ', $str);

        synapse()->memory->arrays()->put($this->key, array_merge($value, $arr));
    }
}
