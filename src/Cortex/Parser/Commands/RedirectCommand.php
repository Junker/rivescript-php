<?php

namespace Axiom\Rivescript\Cortex\Parser\Commands;

use Axiom\Rivescript\Contracts\Command;

class RedirectCommand implements Command
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
        if ($node->command() === '@') {
            $topic   = synapse()->memory->shortTerm()->get('topic') ?: 'random';
            $trigger = synapse()->memory->shortTerm()->get('trigger');

            synapse()->brain->topic($topic)->triggers()->each(function($tr) use ($trigger, $node) {

                if ($tr->source == $node->value())
                {
                    $trigger->redirect = $tr;

                    return true;
                }
            });
        }
    }
}
