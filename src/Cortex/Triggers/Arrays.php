<?php

namespace Axiom\Rivescript\Cortex\Triggers;

use Axiom\Collections\Collection;

class Arrays extends Trigger
{
    /**
     * Parse the trigger.
     *
     * @param string $trigger
     * @param string $message
     *
     * @return array
     */
    public function parse($trigger, $input)
    {
        if (preg_match_all('/@(\w+)/', $trigger, $array_names)) {
            $array_names = $array_names[1];

            $array_names = array_unique($array_names);

            foreach ($array_names as $array_name) {
                if ($array = synapse()->memory->arrays()->get($array_name)) {
                    array_walk($array, 'preg_quote');
                    $array_str = implode('|', $array);

                    $trigger = str_replace("\\(@$array_name\\)", "($array_str)", $trigger);
                    $trigger = str_replace("[@$array_name]", "(?:$array_str)", $trigger);
                    $trigger = str_replace("@$array_name", "(?:$array_str)", $trigger);
                }
            }
        }

        return $trigger;
    }
}
