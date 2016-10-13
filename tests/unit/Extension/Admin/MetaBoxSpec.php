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
    
}

class MetaBoxTest extends MetaBox
{
    public function render()
    {
        return 'some test content';
    }
}