<?php

namespace unit\Spark\Container;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use DI\ContainerBuilder;
use DI\Container;

class ContainerFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Container\ContainerFactory');
    }
    
    function let(ContainerBuilder $ContainerBuilder)
    {
        $this->beConstructedWith($ContainerBuilder);
    }
    
    function it_creates_a_container_instance(
        ContainerBuilder $ContainerBuilder,
        Container $Container
    )
    {
        $ContainerBuilder->addDefinitions(Argument::type( 'array' ))->shouldBeCalled();
        $ContainerBuilder->build()->willReturn($Container);
        $this->create()->shouldReturn($Container);
    }
}
