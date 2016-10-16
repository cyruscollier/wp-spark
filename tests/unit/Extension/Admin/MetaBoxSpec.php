<?php

namespace unit\Spark\Extension\Admin;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Extension\Admin\MetaBox;

class MetaBoxSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Extension\Admin\MetaBox');
    }
    
    function let()
    {
        $this->beAnInstanceOf(MetaBoxTest::class);
    }
    
    function it_registers_the_add_meta_boxes_action($functions)
    {
        $functions->add_action('add_meta_boxes', Argument::type('callable'))->willReturn(true);
        $this->register()->shouldReturn(true);
    }
    
    function it_registers_the_meta_box($functions)
    {
        $functions->add_meta_box(
            'test', 'Test', Argument::type('callable'), 'post', 'advanced', 'default'
        )->willReturn(true);
        $functions->convert_to_screen('post')->willReturn('post');
        $this->init()->shouldReturn(true);
    }
    
    function it_checks_if_metabox_is_registered($functions)
    {
        $this->isRegistered()->shouldReturn(false);
        $GLOBALS['wp_meta_boxes']['post']['advanced']['default']['test'] = ['id' => 'test'];
        $this->isRegistered()->shouldReturn(true);
    }
    
    function it_deregisters_the_metabox($functions)
    {
        $functions->shortcode_exists('test')->willReturn(true);
        $functions->remove_meta_box('test', 'post', 'advanced')->shouldBeCalled();
        $this->deregister()->shouldReturn(true);
    }
    
}

class MetaBoxTest extends MetaBox
{
    protected $id = 'test';
    
    protected $title = 'Test';
    
    protected $screen = 'post';
    
    public function render()
    {
        return 'some test content';
    }
}