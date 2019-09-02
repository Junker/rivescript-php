<?php

namespace Axiom\Rivescript\Cortex\Triggers;

class Wildcard extends Trigger
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

        $wildcards = [
            '/\\\\\\*$/'           => '.*?',
            '/\\\\\\*/'            => '\\w+?',
            '/\\\\#/'              => '\\d+?',
            '/_/'                 => '\p{L}+?',
            '/\<zerowidthstar\>/' => '^\*$',
        ];

        foreach ($wildcards as $pattern => $replacement) {
             $trigger = preg_replace($pattern, '('.$replacement.')', $trigger);
        }

        return $trigger;
    }
}
