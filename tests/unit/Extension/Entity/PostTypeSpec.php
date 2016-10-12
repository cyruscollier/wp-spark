<?php

namespace unit\Spark\Extension\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Extension\Entity\PostType;

class PostTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Extension\Entity\PostType');
    }
        
    function let()
    {
        $this->beAnInstanceOf(PostTypeTest::class);
    }   
    
}

class PostTypeTest extends PostType
{
    const NAME = 'test';
}
