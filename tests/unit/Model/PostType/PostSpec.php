<?php

namespace unit\Spark\Model\PostType;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Model\PostType\Post');
    }
}
