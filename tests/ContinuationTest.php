<?php

namespace Tests;

class ContinuationTest extends ResponseTest
{
    public function testContinuation()
    {
        $response = $this->rivescript->reply('i want an apple');
        $this->assertEquals("we have only oranges", $response);

        $response = $this->rivescript->reply('i want an orange');
        $this->assertEquals("we have only potatos", $response);

    }
}
