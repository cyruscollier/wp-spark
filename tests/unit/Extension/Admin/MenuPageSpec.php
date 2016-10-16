<?php

namespace unit\Spark\Extension\Admin;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Extension\Admin\MenuPage;

class MenuPageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Extension\Admin\MenuPage');
    }
    
    function let()
    {
        $this->beAnInstanceOf(MenuPageTest::class);
    }
    
    function it_registers_the_menu_page($functions)
    {
        $functions->add_menu_page(
            'Test Page Title', 'Test Menu Title', 'manage_options', 'test', Argument::type('callable'), null, null 
        )->willReturn('test');
        $functions->add_action('load-test', Argument::type('callable'))->shouldBeCalled();
        $this->init()->shouldReturn('test');
    }
    
    function it_deregisters_the_menu_page($functions)
    {
        $functions->remove_menu_page('test')->willReturn(['item']);
        $this->deregister()->shouldReturn(true);
    }
}

class MenuPageTest extends MenuPage
{
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