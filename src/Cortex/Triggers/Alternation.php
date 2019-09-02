<?php

namespace Axiom\Rivescript\Cortex\Triggers;

use Axiom\Collections\Collection;

class Alternation extends Trigger
{
    /**
     * Parse the trigger.
     *
     * @param string $trigger
     * @param string $message
     *
     * @return array
     */
    public function parse($trigger, $input)
    {
        return preg_replace_callback('/\\\\\\((.*?)\\\\\\)/', function($match) {

            if (strpos($match[1], '\\|'))
                return '('.str_replace('\\|', '|', $match[1]).')';
            else 
                return $match[0]; 

        }, $trigger);
    }
}
