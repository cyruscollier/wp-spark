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
}

class SubMenuPageTest extends SubMenuPage
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
