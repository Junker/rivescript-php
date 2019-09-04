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

    public function testWeightTag()
    {
        $response = $this->rivescript->reply('pick a color');
        $this->assertContains($response, ['red', 'green', 'blue']);
    }

    public function testFormalTag()
    {
        $response = $this->rivescript->reply('make it formal every word');

        $this->assertEquals('Every Word', $response);
    }

    public function testUppercaseTag()
    {
        $response = $this->rivescript->reply('make it uppercase every word');

        $this->assertEquals('EVERY WORD', $response);
    }

    public function testLowercaseTag()
    {
        $response = $this->rivescript->reply('make it lowercase Every Word');

        $this->assertEquals('every word', $response);
    }

    public function testSentenceTag()
    {
        $response = $this->rivescript->reply('make it sentence every word');

        $this->assertEquals('Every word', $response);
    }


}
