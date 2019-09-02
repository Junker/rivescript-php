<?php

namespace Axiom\Rivescript\Cortex\Triggers;

use Axiom\Collections\Collection;

class Optional extends Trigger
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
        return preg_replace_callback('/\s*\\\\\\[([^\\[\\]]+?)\\\\\\]\s*/', function($match) {

            if ($match[1] == '\\*')
                return '\\b.*\\b';
            elseif (strpos($match[1], '\\|'))
                return '\\s*(?:\\b'.str_replace('\\|', '|', $match[1]).'\\b)?\\s*';
            else 
                return '\\s*(?:\\b'.$match[1].'\\b)?\\s*'; 

        }, $trigger);
    }
}
