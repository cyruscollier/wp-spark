<?php

namespace unit\Spark\Model\Values;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostDateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Model\Values\PostDate');
    }
}
