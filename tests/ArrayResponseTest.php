<?php

namespace Tests;

class ArrayResponseTest extends ResponseTest
{
    public function testArrayStar()
    {
        $response = $this->rivescript->reply('i am wearing a blue shirt');
        $this->assertEquals("I don't know if I have a shirt that's colored blue.", $response);

        $response = $this->rivescript->reply('i am wearing a dirty shirt');
        $this->assertEquals("I'm sorry but I don't understand.", $response);
    }

    public function testArrayPassive()
    {
        $response = $this->rivescript->reply('i have a yellow hat');
        $this->assertEquals("i don't like your hat", $response);

        $response = $this->rivescript->reply('i have a red colored shirt');
        $this->assertEquals("Have you thought about getting a shirt in a different color?", $response);
    }
}
