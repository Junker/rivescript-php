<?php

namespace Vulcan\Rivescript\Cortex\Tags;

class Bot extends Tag
{
    public $pattern = '/<bot (.*)>/i';

    /**
     * Parse the source.
     *
     * @param  String  $source
     * @return String
     */
    public function parse($source)
    {
        if ($this->hasMatches($source)) {
            $matches   = $this->getMatches($source);
            $variables = synapse()->memory->variables();

            foreach ($matches as $match) {
                $source = str_replace($match[0], $variables[$match[1]], $source);
            }
        }

        return $source;
    }
}
