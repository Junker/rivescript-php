<?php

namespace Axiom\Rivescript\Cortex;

use SplFileObject;

class Brain
{
    /**
     * @var Branch
     */
    protected $topics;

    /**
     * Create a new instance of Brain.
     */
    public function __construct()
    {
        $this->createTopic('random');
    }

    /**
     * Teach the brain contents of a new file source.
     *
     * @param string $file
     */
    public function teach($file)
    {
        $file       = new SplFileObject($file);
        $lineNumber = 0;

        while (! $file->eof()) {
            $currentCommand = null;
            $node           = new Node($file->fgets(), $lineNumber++);

            if ($node->isInterrupted() or $node->isComment()) {
                continue;
            }

            $currentCommand = synapse()->parser->parseCommands($node, $currentCommand);
        }
    }

    public function topic($name = null)
    {
        if (is_null($name)) {
            $name = synapse()->memory->shortTerm()->get('topic') ?: 'random';
        }

        if (! isset($this->topics[$name])) {
            return null;
        }

        return $this->topics[$name];
    }

    public function createTopic($name)
    {
        $this->topics[$name] = new Topic($name);

        return $this->topics[$name];
    }
}
