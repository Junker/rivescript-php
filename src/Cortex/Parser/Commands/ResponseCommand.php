<?php

namespace Axiom\Rivescript\Cortex\Parser\Commands;

use Axiom\Rivescript\Contracts\Command;
use Axiom\Rivescript\Cortex\Response;

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

    private $response;

    public function parse($node)
    {
        if ($node->command() === '-') {
            $topic   = synapse()->memory->shortTerm()->get('topic') ?: 'random';
            $trigger = synapse()->memory->shortTerm()->get('trigger');

            $this->response = new Response($node->value());

            $trigger->responses[] = $this->response;

            return true;
        }
    }

    public function addContinuation($str)
    {
        $this->response->source .= $str;
    }


}
