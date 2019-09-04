<?php

namespace Axiom\Rivescript\Cortex\Parser\Tags;

use Axiom\Rivescript\Cortex\Input;

class InputTag extends Tag
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
    protected $pattern = '/<input(\d+)?>/i';

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
            $inputs  = synapse()->memory->user($input->user())->inputs;

            foreach ($matches as $key => $match) {
                $needle = $match[0];
                $index  = empty($match[1]) ? ($inputs->count()-2) : ($inputs->count()-($match[1]+1));

                $source = str_replace($match[0], $inputs->get($index), $source);

                if ($this->sourceType == 'trigger')
                {
                    $source = mb_strtolower($source);
                    $source = preg_replace('/[^\pL\d\s]+/u', '', $source);
                    $source = remove_whitespace($source);
                }
            }
        }

        return $source;
    }
}
