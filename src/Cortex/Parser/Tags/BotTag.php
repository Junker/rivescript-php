<?php

namespace Axiom\Rivescript\Cortex\Parser\Tags;

use Axiom\Rivescript\Cortex\Input;

class BotTag extends Tag
{
    /**
     * @var array
     */
    protected $allowedSources = ['response', 'trigger'];

    /**
     * Regex expression pattern.
     *
     * @var string
     */
    protected $pattern = '/<bot (.+?)>/i';

    /**
     * Parse the source.
     *
     * @param string $source
     *
     * @return string
     */
    public function parse($source, Input $input)
    {
        if (! $this->sourceAllowed()) {
            return $source;
        }

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
