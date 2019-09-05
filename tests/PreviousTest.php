<?php

namespace Tests;

class PreviousTest extends ResponseTest
{
    public function testPreviousCommand()
    {
        $response = $this->rivescript->reply('i have a dog');
        $this->assertEquals('What color is it?', $response);

        $response = $this->rivescript->reply('green');
        $this->assertEquals("That's an odd color for a dog.", $response);

        $response = $this->rivescript->reply('i have a car');
        $response = $this->rivescript->reply('green');
        $this->assertFalse("That's an odd color for a dog." == $response);

    }

    public function testPrevious2Command()
    {
        $response = $this->rivescript->reply('knock knock');
        $this->assertEquals("Who's there?", $response);

        $response = $this->rivescript->reply('guevara');
        $this->assertEquals("guevara who?", $response);

        $response = $this->rivescript->reply('che guevara');
        $this->assertEquals("lol! che guevara! That's hilarious!", $response);
    }

}
