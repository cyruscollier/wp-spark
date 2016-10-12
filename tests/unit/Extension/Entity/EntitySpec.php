<?php

namespace unit\Spark\Extension\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Extension\Entity\Entity;

class EntitySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Extension\Entity\Entity');
    }
        
    function let()
    {
        $this->beAnInstanceOf(EntityTest::class);
    }    
    
    function it_registers_the_init_action( $functions ) {
        $functions->add_action('init', [$this->getWrappedObject(), 'init'], 1)->willReturn(true);
        $this->register()->shouldReturn(true);
    }
}

class EntityTest extends Entity
{
    function getType() { return 'EntityTest'; }
        
    function isRegistered() { return true; }
    
    function deregister() { return true; }
    
    protected function registerCustom( $config )
    {
        return $config;
    }
}
