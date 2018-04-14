<?php

namespace unit\Spark\Extension\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Extension\RegisterEntity\PostType;

class RegisterPostTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Extension\RegisterEntity\RegisterPostType');
    }
        
    function let()
    {
        $this->beAnInstanceOf(PostTypeTest::class);
    }
    
    function it_registers_a_post_type($functions)
    {
        $post_type = new \stdClass();
        $functions->register_post_type('test', Argument::type('array'))->willReturn($post_type);
        $this->init()->shouldReturn($post_type);
    }
    
    function it_deregisters_a_post_type()
    {
        $GLOBALS['wp_post_types']['test'] = new \stdClass();
        $this->deregister()->shouldReturn(true);
        $this->deregister()->shouldReturn(false);
    }
    
    function it_checks_if_post_type_is_registered($functions)
    {
        $functions->post_type_exists('test')->willReturn(true);
        $this->isRegistered()->shouldReturn(true);
    }
    
}

class PostTypeTest extends PostType
{
    const NAME = 'test';
}
