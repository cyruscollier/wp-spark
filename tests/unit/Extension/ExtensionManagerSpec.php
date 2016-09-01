<?php

namespace unit\Spark\Extension;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Interop\Container\ContainerInterface;

class ExtensionManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Extension\ExtensionManager');
    }
    
    function let(ContainerInterface $Container)
    {
        $this->beConstructedWith($Container);
    }
}
