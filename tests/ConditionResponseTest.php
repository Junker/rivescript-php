<?php

namespace Tests;

class ConditionResponseTest extends ResponseTest
{
    public function testCondition()
    {
        $response = $this->rivescript->reply('how you call me');
        $this->assertEquals("You never told me your name.", $response);

        $response = $this->rivescript->reply('5 and 3');
        $this->assertEquals("greatter", $response);

       $response = $this->rivescript->reply('1 and 3');
       $this->assertEquals("lesser", $response);

    }
}
