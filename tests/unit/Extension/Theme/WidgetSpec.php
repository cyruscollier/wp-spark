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
}

class WidgetTest extends Widget
{
    public function render()
    {
        return 'some test content';
    }
}
