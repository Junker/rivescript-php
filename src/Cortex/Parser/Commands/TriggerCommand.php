<?php

namespace Axiom\Rivescript\Cortex\Parser\Commands;

use Axiom\Rivescript\Cortex\Trigger;
use Axiom\Collections\Collection;
use Axiom\Rivescript\Contracts\Command;


class TriggerCommand implements Command
{
    /**
     * Parse the command.
     *
     * @param Node   $node
     * @param string $command
     *
     * @return array
     */

    private $trigger;

    public function parse($node)
    {
        if ($node->command() === '+') {
            $topic = synapse()->memory->shortTerm()->get('topic') ?: 'random';
            $topic = synapse()->brain->topic($topic);
            $type  = $this->determineTriggerType($node->value());

            $trigger = new Trigger($node->value(), $type);

            $this->trigger = $trigger;
            $topic->triggers->push($trigger);
            $topic->triggers = $this->sortTriggers($topic->triggers);

            synapse()->memory->shortTerm()->put('trigger', $trigger);

            return true;
        }
    }

    /**
     * Determine the type of trigger to aid in sorting.
     *
     * @param string $trigger
     *
     * @return string
     */
    protected function determineTriggerType($triggerRow)
    {
        $wildcards = [
            Trigger::TYPE_GLOBAL_ONLY => '/^\s*\*\s*$/',
            Trigger::TYPE_GLOBAL     => '/\*/',
            Trigger::TYPE_NUMERIC    => '/#/',
            Trigger::TYPE_ALPHABETIC => '/_/',
            Trigger::TYPE_OPTIONAL => '/\[.*\]/',
        ];

        foreach ($wildcards as $type => $pattern) {
            if (@preg_match_all($pattern, $triggerRow, $stars)) {
                return $type;
            }
        }

        return 'atomic';
    }

    /**
     * Sort triggers based on type and word count from
     * largest to smallest.
     *
     * @param Collection $triggers
     *
     * @return Collection
     */
    protected function sortTriggers($triggers)
    {
        $this->determineWordCount($triggers);
        $this->determineTypeCount($triggers);

        $triggers = $triggers->sort(function ($current, $previous) {
            return ($current->order < $previous->order) ? -1 : 1;
        })->reverse();

        return $triggers;
    }

    protected function determineTypeCount($triggers)
    {
        $triggers = $triggers->each(function ($trigger) {
            switch ($trigger->type) {
                case Trigger::TYPE_ATOMIC:
                    $trigger->order += 5000000;
                    break;
                case Trigger::TYPE_OPTIONAL:
                    $trigger->order += 4000000;
                    break;
                case Trigger::TYPE_ALPHABETIC:
                    $trigger->order += 3000000;
                    break;
                case Trigger::TYPE_NUMERIC:
                    $trigger->order += 2000000;
                    break;
                case Trigger::TYPE_GLOBAL:
                    $trigger->order += 1000000;
                    break;
                case Trigger::TYPE_GLOBAL_ONLY:
                    $trigger->order += 500000;
                    break;
            }

            if ($trigger->previous)
                $trigger->order += 1;
        });
    }

    /**
     * Sort triggers based on word count from
     * largest to smallest.
     *
     * @param Collection $triggers
     *
     * @return Collection
     */
    protected function determineWordCount($triggers)
    {
        $triggers->each(function ($trigger) {
            $trigger->order = count(explode(' ', $trigger->source));
        });

    }


    public function addContinuation($str)
    {
        $this->trigger->source .= $str;
    }
}
