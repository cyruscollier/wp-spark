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
}

class MenuPageTest extends MenuPage
{

    public function prepare($arguments)
    {
        return $arguments;
    }
    
    public function render()
    {
        return 'some test content';
    }
}