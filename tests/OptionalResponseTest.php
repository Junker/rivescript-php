<?php

namespace Tests;

class OptionalResponseTest extends ResponseTest
{
    public function testOptionalWord()
    {
        $response = $this->rivescript->reply('what is your home phone number');
        $this->assertEquals("123123123", $response);

        $response = $this->rivescript->reply('what is your phone number');
        $this->assertEquals("123123123", $response);

        $response = $this->rivescript->reply('what is your work phone number');
        $this->assertEquals("I'm sorry but I don't understand.", $response);
    }

    public function testOptionalMultipleWord()
    {
        $response = $this->rivescript->reply('i have a green car');
        $this->assertEquals("I bet you like your car a lot.", $response);

        $response = $this->rivescript->reply('i have a car');
        $this->assertEquals("I bet you like your car a lot.", $response);

        $response = $this->rivescript->reply('i have car');
        $this->assertEquals("I'm sorry but I don't understand.", $response);
    }

    public function testOptionalStar()
    {
        $response = $this->rivescript->reply('English indie rock band, Florence and the Machine will perform a third show');
        $this->assertEquals("How do you know about the machine!?", $response);

        $response = $this->rivescript->reply('the machine - movie 2013');
        $this->assertEquals("How do you know about the machine!?", $response);

        $response = $this->rivescript->reply('what is your work phone number');
        $this->assertEquals("I'm sorry but I don't understand.", $response);
    }
}
