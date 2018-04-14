<?php

namespace unit\Spark\Extension;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Interop\Container\ContainerInterface;
use Spark\Extension\Extension;
use Spark\Model\PostType\Post;

class ExtensionManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Extension\ExtensionManager');
    }
    
    function let(
        ContainerInterface $Container,
        Extension $Extension1,
        Extension $Extension2
    )
    {
        $this->beConstructedWith($Container);

        $Extension1->getType()->willReturn('type1');
        $Extension2->getType()->willReturn('type2');
    }
    
    function it_registers_one_or_more_extensions(
        ContainerInterface $Container,
        Extension $Extension1,
        Extension $Extension2
    )
    {
        $Container->get('extension1')->willReturn($Extension1);
        $Container->get('extension2')->willReturn($Extension2);
        $this->it_expects_extension_register($Extension1);
        $this->it_expects_extension_register($Extension2);
        $this->registerExtensions(['extension1', 'extension2'])
             ->shouldReturn([$Extension1, $Extension2]);
    }
    
    function it_skips_an_extension_already_registered(
        ContainerInterface $Container,
        Extension $Extension1,
        Extension $Extension2
    )
    {
        $Container->get('extension1')->willReturn($Extension1);
        $Container->get('extension2')->willReturn($Extension2);
        $this->it_expects_extension_register($Extension1);
        $Extension2->isRegistered()->willReturn(true);
        $Extension2->register()->shouldNotBeCalled();
        $this->registerExtensions(['extension1', 'extension2'])
             ->shouldReturn([$Extension1]);
    }
    
    function it_fails_to_register_a_non_extension_type(
        ContainerInterface $Container
    )
    {
        $Container->get('post')->willReturn(new Post());
        $this->shouldThrow(\InvalidArgumentException::class)->duringRegisterExtensions(['post']);
    }
    
    function it_deregisters_one_or_more_extensions(
        ContainerInterface $Container,
        Extension $Extension1,
        Extension $Extension2
    )
    {
        $Container->get('extension1')->willReturn($Extension1);
        $Container->get('extension2')->willReturn($Extension2);
        $this->it_expects_extension_register($Extension1);
        $this->it_expects_extension_register($Extension2);
        $this->registerExtensions(['extension1', 'extension2']);
        $this->it_expects_extension_deregister($Extension1);
        $this->it_expects_extension_deregister($Extension2);
        $this->deregisterExtensions(['extension1', 'extension2'])
             ->shouldReturn([$Extension1, $Extension2]);
    }
    
    function it_skips_an_extension_not_registered(
        ContainerInterface $Container,
        Extension $Extension1,
        Extension $Extension2
    )
    {
        $Container->get('extension1')->willReturn($Extension1);
        $Container->get('extension2')->willReturn($Extension2);
        $this->it_expects_extension_deregister($Extension1);
        $Extension2->isRegistered()->willReturn(false);
        $Extension2->deregister()->shouldNotBeCalled();
        $this->deregisterExtensions(['extension1', 'extension2'])
             ->shouldReturn([$Extension1]);
    }
    
    function it_fails_to_deregister_a_non_extension_type(
        ContainerInterface $Container
    )
    {
        $Container->get('post')->willReturn(new Post());
        $this->shouldThrow(\InvalidArgumentException::class)->duringDeregisterExtensions(['post']);
    }

    private function it_expects_extension_register(Extension $Extension)
    {
        $Extension->isRegistered()->willReturn(false);
        $Extension->register()->shouldBeCalled();
    }

    private function it_expects_extension_deregister(Extension $Extension)
    {
        $Extension->isRegistered()->willReturn(true);
        $Extension->deregister()->shouldBeCalled();
    }
}
