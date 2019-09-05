<?php

namespace Axiom\Rivescript\Cortex\Parser\Commands;

use Axiom\Rivescript\Contracts\Command;

class PreviousCommand implements Command
{
    private $trigger;

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
        if ($node->command() === '%') {
            $topic   = synapse()->memory->shortTerm()->get('topic') ?: 'random';
            $trigger = synapse()->memory->shortTerm()->get('trigger');

            $this->trigger = $trigger;

            $trigger->previous = $node->value();

            return true; 
        }
    }

    public function addContinuation($str)
    {
        $this->trigger->previous .= $str;
    }
}
