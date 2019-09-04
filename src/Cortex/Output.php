<?php

namespace Axiom\Rivescript\Cortex;

use Axiom\Collections\Collection;
use Axiom\Rivescript\Support\Arr;


class Output
{
    protected const ERROR_MESSAGE = 'Error: Response could not be determined.';
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
    protected $output = self::ERROR_MESSAGE;

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
        synapse()->memory->user($this->input->user())->inputs->push($this->input->original());

        synapse()->brain->topic()->triggers()->each(function ($trigger) {

            $parsedTrigger = $this->parseTriggerTags($trigger->source);

            if (empty(trim($parsedTrigger))) return;

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


            if ($this->output !== self::ERROR_MESSAGE) {
                synapse()->memory->user($this->input->user())->replies->push($this->output);
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

        foreach ($trigger->conditions as $condition) {
            if ($condition->assert($this->input)) {
                $this->output = $this->parseResponseTags($condition->response->source);
                return;
            }
        }

        $responses = [];
        $weights = [];
        foreach ($trigger->responses as $response) {
            $responses[] = $response->source;
            $weights[] = $response->weight;
        }

        $response = count($weights) == array_sum($weights) ? $responses[array_rand($responses)] : Arr::weightedRandom($responses, $weights);

        $this->output = $this->parseResponseTags($response);
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
