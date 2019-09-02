<?php

namespace Tests;

class TagsTest extends ResponseTest
{
    public function testRandomTag()
    {
        $response = $this->rivescript->reply('say something random');

        $this->assertContains($response, ['This message has a random word.', 'This sentence has a random word.']);
    }
}
