<?php

namespace Axiom\Rivescript\Cortex\Parser\Tags;

use Axiom\Rivescript\Cortex\Input;
use Axiom\Rivescript\Support\Str;

class SentenceTag extends Tag
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
    protected $pattern = '/\{sentence\}(.+?)\{\/sentence\}/u';

    /**
     * Parse the response.
     *
     * @param string $response
     * @param array  $data
     *
     * @return array
     */
    public function parse($source, Input $input)
    {
        if (! $this->sourceAllowed()) {
            return $source;
        }

        if ($this->hasMatches($source)) {
            $matches = $this->getMatches($source)[0];

            $source = str_replace($matches[0], Str::ucfirst($matches[1]), $source);
        }

        return $source;
    }
}
