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
    
    function it_checks_if_shortcode_is_registered($functions)
    {
        $functions->shortcode_exists('test')->willReturn(true);
        $this->isRegistered()->shouldReturn(true);
    }
    
    function it_deregisters_the_shortcode($functions)
    {
        $functions->shortcode_exists('test')->willReturn(true);
        $functions->remove_shortcode('test')->shouldBeCalled();
        $this->deregister()->shouldReturn(true);
    }
}

class ShortcodeTest extends Shortcode
{
    const TAG = 'test';
    
    public function render()
    {
        return 'some test content';
    }
}