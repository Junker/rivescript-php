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
    public function parse($node, $command)
    {
        if ($node->command() === '+') {
            $topic = synapse()->memory->shortTerm()->get('topic') ?: 'random';
            $topic = synapse()->brain->topic($topic);
            $type  = $this->determineTriggerType($node->value());

            $trigger = new Trigger($node->value(), $type);

            $topic->triggers->push($trigger);

            $topic->triggers = $this->sortTriggers($topic->triggers);

            synapse()->memory->shortTerm()->put('trigger', $trigger);
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
            Trigger::TYPE_ALPHABETIC => '/_/',
            Trigger::TYPE_NUMERIC    => '/#/',
            Trigger::TYPE_GLOBAL     => '/\*/',
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
            }
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
            $trigger->order = count(explode(' ', $trigger->row));
        });

    }
}