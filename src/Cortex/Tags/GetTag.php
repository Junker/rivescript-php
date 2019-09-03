<?php

namespace Axiom\Rivescript\Cortex\Tags;

use Axiom\Rivescript\Cortex\Input;

class GetTag extends Tag
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
    protected $pattern = '/<get (.+?)>/u';

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
            $matches  = $this->getMatches($source)[0];
            $userData = synapse()->memory->user($input->user())->get($matches[1]) ?? 'undefined';

            $source = str_replace($matches[0], $userData, $source);
        }

        return $source;
    }
}
