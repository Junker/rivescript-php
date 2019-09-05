<?php

namespace Axiom\Rivescript\Cortex\Parser\Tags;

use Axiom\Rivescript\Cortex\Input;
use Axiom\Rivescript\Support\Str;

class PersonStarTag extends Tag
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
    protected $pattern = '/<person>/i';

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
            $persons  = synapse()->memory->person()->all();

            $str = $stars[0];

            foreach ($persons as $search => $replace) {
                $str = preg_replace("/\b".preg_quote($search)."\b/ui", $replace, $str);
            }

            foreach ($matches as $key => $match) {
                $source = str_replace($match[0], $str, $source);
            }
        }

        return $source;
    }
}
