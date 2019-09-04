<?php

namespace Tests;

class TagsTest extends ResponseTest
{
    public function testRandomTag()
    {
        $response = $this->rivescript->reply('say something random');

        $this->assertContains($response, ['This message has a random word.', 'This sentence has a random word.']);
    }

    public function testGetTag()
    {
        $response = $this->rivescript->reply('my name is Rive');
        $this->assertEquals('Nice to meet you!', $response);

        $response = $this->rivescript->reply('what is my name');
        $this->assertEquals('Your name is rive!', $response);

    }    

    public function testReplyTag()
    {
        $response = $this->rivescript->reply('hello bot');
        $this->assertEquals('Hello human.', $response);

        $response = $this->rivescript->reply('repeat');
        $this->assertEquals('Hello human.', $response);

        $response = $this->rivescript->reply('Hello human.');
        $this->assertEquals('Do not repeat after me', $response);
    }

    public function testInputTag()
    {
        $response = $this->rivescript->reply('hello bot');
        $this->assertEquals('Hello human.', $response);

        $response = $this->rivescript->reply('what i just said');
        $this->assertEquals('hello bot', $response);
    }

    public function testIdTag()
    {
        $response = $this->rivescript->reply('my id');
        $this->assertEquals('your id is 0', $response);
    }
}
