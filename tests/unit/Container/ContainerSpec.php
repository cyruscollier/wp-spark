<?php

namespace unit\Spark\Container;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContainerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Container\Container');
    }
}
