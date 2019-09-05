<?php

namespace Axiom\Rivescript\Cortex\Parser\Tags;

use Axiom\Rivescript\Cortex\Input;
use Axiom\Rivescript\Support\Str;

class PersonTag extends Tag
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
    protected $pattern = '/\{person\}(.+?)\{\/person\}/u';

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
            $persons  = synapse()->memory->person()->all();

            $str = $matches[1];

            foreach ($persons as $search => $replace) {
                $str = preg_replace("/\b".preg_quote($search)."\b/ui", $replace, $str);
            }

            $source = str_replace($matches[0], $str, $source);
        }

        return $source;
    }
}
