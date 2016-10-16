<?php

namespace unit\Spark\Extension\Admin;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Extension\Admin\Page;

class PageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Extension\Admin\Page');
    }
    
    function let()
    {
        $this->beAnInstanceOf(PageTest::class);
    }
    
    function it_registers_the_admin_menu_action($functions) {
        $functions->add_action('admin_menu', Argument::type('callable'))->willReturn(true);
        $this->register()->shouldReturn(true);
    }
    
    function it_checks_if_page_is_registered()
    {
        $this->isRegistered()->shouldBe(false);
        $GLOBALS['admin_page_hooks']['test'] = 'test';
        $this->isRegistered()->shouldBe(true);
    }
}

class PageTest extends Page
{

    protected $menu_slug = 'test';
    
    public function deregister()
    {
        return true;
    }
    
    public function prepare($arguments)
    {
        return $arguments;
    }
    
    public function render()
    {
        return 'some test content';
    }
    
    protected function registerPage()
    {
        return 'test';
    }
}
