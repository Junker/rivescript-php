<?php

namespace Axiom\Rivescript\Cortex\Parser\Tags;

use Axiom\Rivescript\Cortex\Input;

class EolTag extends Tag
{
    /**
     * @var array
     */
    protected $allowedSources = ['response'];

    /**
     * Regex expression pattern.
     *
     * @var string
     */
    protected $pattern = '/\s*+\\\\n\s*/';

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

            foreach ($matches as $match) {
                $source = str_replace($match[0], PHP_EOL, $source);
            }
        }

        return $source;
    }
}
