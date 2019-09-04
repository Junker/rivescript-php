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
        $this->assertEquals($response, 'Nice to meet you!');

        $response = $this->rivescript->reply('what is my name');
        $this->assertEquals($response, 'Your name is rive!');

    }    

    public function testReplyTag()
    {
        $response = $this->rivescript->reply('hello bot');
        $this->assertEquals($response, 'Hello human.');

        $response = $this->rivescript->reply('repeat');
        $this->assertEquals($response, 'Hello human.');

        $response = $this->rivescript->reply('Hello human.');
        $this->assertEquals($response, 'Do not repeat after me');

    }

}
