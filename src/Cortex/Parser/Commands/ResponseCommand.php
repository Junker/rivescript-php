<?php

namespace Axiom\Rivescript\Cortex\Parser\Commands;

use Axiom\Rivescript\Contracts\Command;

class ResponseCommand implements Command
{
    /**
     * Parse the command.
     *
     * @param Node   $node
     * @param string $command
     *
     * @return array
     */

    private $trigger;

    public function parse($node)
    {
        if ($node->command() === '-') {
            $topic   = synapse()->memory->shortTerm()->get('topic') ?: 'random';
            $trigger = synapse()->memory->shortTerm()->get('trigger');

            $this->trigger = $trigger;

            $trigger->responses[] = $node->value();

            return true;
        }
    }

    public function addContinuation($str)
    {
        $this->trigger->responses[count($this->trigger->responses)-1] .= $str;
    }


}
