<?php

namespace unit\Spark\Model\Values;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Model\MetadataCollection;
use Spark\Model\Values\PostMetaField;

class PostMetaFieldSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Model\Values\PostMetaField');
    }
    
    function let()
    {
        $this->beConstructedWith('some_key', 'some_value');
    }
    
    function it_can_be_cast_as_string()
    {
        $this->__toString()->shouldReturn('some_value');
    }
    
    function it_creates_an_updated_instance_from_a_value()
    {
        $this->update('some_other_value')->shouldReturnAnInstanceOf(PostMetaField::class);
    }
    
    function it_creates_an_updated_instance_from_another_instance()
    {
        $field = new PostMetaField('some_key', 'some_other_value');
        $this->update($field)->shouldReturnAnInstanceOf(PostMetaField::class);
    }
}
