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
}

class PageTest extends Page
{

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
        return true;
    }
}
