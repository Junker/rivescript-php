<?php

namespace Axiom\Rivescript\Cortex\Parser\Tags;

use Axiom\Rivescript\Cortex\Input;
use Axiom\Rivescript\Support\Str;

class SentenceStarTag extends Tag
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
    protected $pattern = '/<sentence>/i';

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
            $matches = $this->getMatches($source);
            $stars   = synapse()->memory->shortTerm()->get('stars');

            foreach ($matches as $key => $match) {
                $source = str_replace($match[0], Str::ucfirst($stars[0]), $source);
            }
        }

        return $source;
    }
}
