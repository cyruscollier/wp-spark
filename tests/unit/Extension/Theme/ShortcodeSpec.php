<?php

namespace unit\Spark\Extension\Theme;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Extension\Theme\Shortcode;

class ShortcodeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Extension\Theme\Shortcode');
    }
    
    function let()
    {
        $this->beAnInstanceOf(ShortcodeTest::class);
    }
    
    function it_registers_the_shortcode($functions)
    {
        $functions->add_shortcode('test', Argument::type('callable'))->shouldBeCalled();
        $this->register()->shouldReturn(true);
    }
    
    function it_checks_if_shortcode_is_registered_true($functions)
    {
        $functions->shortcode_exists('test')->willReturn(true);
        $this->isRegistered()->shouldReturn(true);
    }
    
    function it_checks_if_shortcode_is_registered_false($functions)
    {
        $functions->shortcode_exists('test')->willReturn(false);
        $this->isRegistered()->shouldReturn(false);
    }
    
    function it_deregisters_the_shortcode($functions)
    {
        $functions->shortcode_exists('test')->willReturn(true);
        $functions->remove_shortcode('test')->shouldBeCalled();
        $this->deregister()->shouldReturn(true);
    }
    
    function it_prevents_deregistering_an_unregistered_shortcode($functions)
    {
        $functions->shortcode_exists('test')->willReturn(false);
        $functions->remove_shortcode('test')->shouldNotBeCalled();
        $this->deregister()->shouldReturn(false);
    }

    function it_renders_the_shortcode($functions)
    {
        $arguments = ['post' => 1];
        $functions->shortcode_atts([], $arguments)->willReturn($arguments);
        $this->renderShortcode($arguments, 'passed content')
             ->shouldReturn('some test content for post: 1, passed content');
    }
}

class ShortcodeTest extends Shortcode
{
    const TAG = 'test';
    
    public function render()
    {
        echo 'some test content for post: ' . $this->arguments['post'] . ', ' . $this->content;
    }
}