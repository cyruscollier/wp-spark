<?php

namespace unit\Spark\Model\ActiveRecord\PostType;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Model\ActiveRecord\PostType\Post');
    }
}
