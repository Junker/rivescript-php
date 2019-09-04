<?php

namespace Axiom\Rivescript\Cortex\Parser\Commands;

use Axiom\Rivescript\Contracts\Command;

class ContinueCommand implements Command
{
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
        if ($node->command() === '^') {
            $topic   = synapse()->memory->shortTerm()->get('topic') ?: 'random';
            $command = synapse()->memory->shortTerm()->get('last_command');

            if ($command)
                $command->addContinuation(' '.$node->value());

            return true; 
        }
    }
}
