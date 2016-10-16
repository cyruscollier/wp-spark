<?php

namespace unit\Spark\Extension\Admin;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Extension\Admin\SubMenuPage;

class SubMenuPageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Extension\Admin\SubMenuPage');
    }
    
    function let()
    {
        $this->beAnInstanceOf(SubMenuPageTest::class);
    }
    
    function it_registers_the_submenu_page($functions)
    {
        $functions->add_submenu_page(
            'test_parent', 'Test Page Title', 'Test Menu Title', 'manage_options', 'test', Argument::type('callable') 
        )->willReturn('test');
        $functions->add_action('load-test', Argument::type('callable'))->shouldBeCalled();
        $this->init()->shouldReturn('test');
    }
    
    function it_deregisters_the_submenu_page($functions)
    {
        $functions->remove_submenu_page('test')->willReturn(['item']);
        $this->deregister()->shouldReturn(true);
    }
}

class SubMenuPageTest extends SubMenuPage
{
    protected $parent_slug = 'test_parent';
    protected $page_title = 'Test Page Title';
    protected $menu_title = 'Test Menu Title';
    protected $menu_slug = 'test';
    
    public function prepare($arguments)
    {
        return $arguments;
    }
    
    public function render()
    {
        return 'some test content';
    }
}
