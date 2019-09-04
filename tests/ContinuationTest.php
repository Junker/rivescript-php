<?php

namespace Tests;

class ContinuationTest extends ResponseTest
{
    public function testContinuation()
    {
        $response = $this->rivescript->reply('i want an apple');
        $this->assertEquals("we have only oranges", $response);

        $response = $this->rivescript->reply('i want an orange');
        $this->assertEquals("we have only potatoes", $response);

        $this->assertEquals("this is variable with continuation", synapse()->memory->variables()->get('cont'));
        $this->assertEquals(['red', 'green', 'blue', 'cyan', 'magenta', 'yellow', 'black', 'white', 'orange', 'brown'], synapse()->memory->arrays()->get('colors_cont'));


    }
}
