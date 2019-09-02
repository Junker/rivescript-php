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
        return preg_replace('/\s+\\\\\\[([^\\[\\]]+?)\\\\\\]\s+/', '\\s*(?:$1)?\\s*', $trigger);
    }
}
