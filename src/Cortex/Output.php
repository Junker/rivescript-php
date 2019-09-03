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
        synapse()->brain->topic()->triggers()->each(function ($trigger) {

            $parsedTrigger = $this->parseTriggerTags($trigger->row);
            $parsedTrigger = $this->parseTriggers($parsedTrigger);

            $result = preg_match_all('/'.$parsedTrigger.'$/ui', $this->input->source(), $stars);

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
     * Fetch a response from the found trigger.
     *
     * @param string $trigger;
     *
     * @return void
     */
    protected function getResponse($trigger)
    {
        if (isset($trigger->redirect)) {
            return $this->getResponse($trigger->redirect);
        }



        $key          = array_rand($trigger->responses);
        $this->output = $this->parseResponseTags($trigger->responses[$key]);
    }



    /**
     * Parse the response through the available tags.
     *
     * @param string $response
     *
     * @return string
     */
    protected function parseResponseTags($response)
    {
        return synapse()->parser->parseResponseTags($response, $this->input);
    }

    /**
     * Parse the trigger through the available tags.
     *
     * @param string $trigger
     *
     * @return string
     */
    protected function parseTriggerTags($trigger)
    {
        return synapse()->parser->parseTriggerTags($trigger, $this->input);
    }

    /**
     * Parse triggers to find a possible match.
     *
     * @param string $trigger
     *
     * @return bool
     */
    protected function parseTriggers($trigger)
    {
        return synapse()->parser->parseTriggers($trigger, $this->input);
    }
}
