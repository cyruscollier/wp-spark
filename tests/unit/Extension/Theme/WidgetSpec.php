<?php

namespace unit\Spark\Extension\Theme;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Extension\Theme\Widget;

class WidgetSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Extension\Theme\Widget');
    }
    
    function let()
    {
        $this->beAnInstanceOf(WidgetTest::class);
    }  
    
    function it_registers_the_widgets_init_action( $functions ) {
        $functions->add_action('widgets_init', Argument::type('callable'))->willReturn(true);
        $this->register()->shouldReturn(true);
    }
    
    function it_registers_the_widget($functions)
    {
        $functions->register_widget($this->getWrappedObject())->shouldBeCalled();
        $this->init();
    }
    
    function it_checks_if_widget_is_registered($functions)
    {
        global $wp_widget_factory;
        $wp_widget_factory = (object) ['widgets' => []];
        $this->isRegistered()->shouldReturn(false);
        $wp_widget_factory->widgets[] = $this->getWrappedObject();
        $this->isRegistered()->shouldReturn(true);
    }
    
    function it_deregisters_the_widget($functions)
    {
        global $wp_widget_factory;
        $instance = $this->getWrappedObject();
        $GLOBALS['wp_widget_factory'] = (object) ['widgets' => [$instance]];
        $functions->unregister_widget( $instance )->shouldBeCalled();
        $this->deregister()->shouldReturn(true);
    }
    
    
}

require_once 'tests/unit/stubs.php';

class WidgetTest extends Widget
{
    public function render()
    {
        return 'some test content';
    }
}
