<?php

namespace Axiom\Rivescript\Cortex;

use Axiom\Collections\Collection;

class Output
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var Input
     */
    protected $input;

    /**
     * @var string
     */
    protected $output = 'Error: Response could not be determined.';

    /**
     * Create a new Output instance.
     *
     * @param Input $input
     */
    public function __construct(Input $input)
    {
        $this->input = $input;
    }

    /**
     * Process the correct output response by the interpreter.
     *
     * @return mixed
     */
    public function process()
    {
        synapse()->brain->topic()->triggers()->each(function ($data, $trigger) {

            $trigger = $this->parseTags($trigger);
            $regx_trigger = $this->proccessTriggers($trigger);

            $result = preg_match_all('/'.$regx_trigger.'$/ui', $this->input->source(), $stars);

            if ($result) {
                if (isset($stars[1])) {
                    array_shift($stars);
                    
                    $stars = Collection::make($stars)->flatten()->all();

                    synapse()->memory->shortTerm()->put('stars', $stars);

                }

                $this->getResponse($trigger);

            }


            if ($this->output !== 'Error: Response could not be determined.') {
                return false;
            }
        });

        return $this->output;
    }

    /**
     * proccess triggers to find a possible match.
     *
     * @param string $trigger
     *
     * @return bool
     */
    protected function proccessTriggers($trigger)
    {
        $trigger = preg_quote($trigger);

        synapse()->triggers->each(function ($class) use (&$trigger) {
            $triggerClass = "\\Axiom\\Rivescript\\Cortex\\Triggers\\$class";
            $triggerClass = new $triggerClass();

            $trigger = $triggerClass->parse($trigger, $this->input);
        });
        
        return $trigger;
    }

    /**
     * Fetch a response from the found trigger.
     *
     * @param string $trigger;
     *
     * @return void
     */
    protected function getResponse($trigger)
    {
        $trigger = synapse()->brain->topic()->triggers()->get($trigger);
        if (isset($trigger['redirect'])) {
            return $this->getResponse($trigger['redirect']);
        }

        $key          = array_rand($trigger['responses']);
        $this->output = $this->parseResponse($trigger['responses'][$key]);
    }

    /**
     * Parse the response through the available tags.
     *
     * @param string $response
     *
     * @return string
     */
    protected function parseResponse($response)
    {
        synapse()->tags->each(function ($tag) use (&$response) {
            $class = "\\Axiom\\Rivescript\\Cortex\\Tags\\$tag";
            $tagClass = new $class();

            $response = $tagClass->parse($response, $this->input);
        });

        return $response;
    }

    protected function parseTags($trigger)
    {
        synapse()->tags->each(function ($tag) use (&$trigger) {
            $class = "\\Axiom\\Rivescript\\Cortex\\Tags\\$tag";
            $tagClass = new $class('trigger');

            $trigger = $tagClass->parse($trigger, $this->input);
        });

        return mb_strtolower($trigger);
    }
}
