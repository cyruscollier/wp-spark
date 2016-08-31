<?php

namespace unit\Spark\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Model\Values\PostMetaField;
use Spark\Model\MetadataCollection;
use Spark\Model\Values\TermMetaField;

class MetadataCollectionSpec extends ObjectBehavior
{
    
    const META_KEY = 'meta_key_set';
    protected $field1;
    protected $field2;
    
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Model\MetadataCollection');
        $this->shouldImplement('ArrayAccess');
        $this->shouldImplement('Spark\Support\Collection');
    }
    
    function let()
    {
        $this->field1 = new PostMetaField(self::META_KEY, '1');
        $this->field2 = new PostMetaField(self::META_KEY, '2');
        $this->beConstructedWith([$this->field1, $this->field2]);
    }
    
    function it_gets_all_collection_instances()
    {
        $this->getValue()->shouldReturn([$this->field1, $this->field2]);
        $this->offsetExists(0)->shouldBe(true);
        $this->offsetExists(1)->shouldBe(true);
    }
    
    function it_can_be_cast_as_string()
    {
        $this->__toString()->shouldReturn('1,2');
    }
    
    function it_adds_or_updates_a_collection_field()
    {
        $field1_updated = $this->field1->updateValue('101');
        $this->add($field1_updated)->shouldReturn($this->getWrappedObject());
        $this->offsetGet(0)->shouldBeLike($field1_updated);
        $field3 = new PostMetaField(self::META_KEY, '3');
        $this->add($field3);
        $this->shouldHaveCount(3);
        $this->offsetGet(2)->shouldReturn($field3);
        $field2_updated = $this->field2->updateValue('102');
        $this->update($field2_updated);
        $this->offsetGet(1)->shouldBeLike($field2_updated);
    }
    
    function it_updates_fields_with_another_collection()
    {
        $field1_updated = $this->field1->updateValue('101');
        $field2_updated = $this->field2->updateValue('102'); 
        $field3 = new PostMetaField(self::META_KEY, '3');
        $collection = new MetadataCollection([$field1_updated, $field2_updated, $field3]);
        $this->update($collection)->shouldReturn($this->getWrappedObject());
        $this->offsetGet(0)->shouldBeLike($field1_updated);
        $this->offsetGet(1)->shouldBeLike($field2_updated);
        $this->offsetGet(2)->shouldBeLike($field3);
    }
    
    function it_removes_a_collection_field()
    {
        $this->remove($this->field1)->shouldReturn($this->getWrappedObject());
        $this->offsetGet(0)->shouldBe(null);
        $this->offsetExists(0)->shouldBe(false);
        $this->getValue()->shouldReturn([$this->field2]);
        $this->shouldHaveCount(1);
    }
    
    function it_disallows_an_invalid_field_in_collection()
    {
        $field = new TermMetaField(self::META_KEY, 'term value');
        $this->shouldThrow(\InvalidArgumentException::class)->duringAdd($field);
        $this->shouldThrow(\InvalidArgumentException::class)->duringRemove($field);
        $field = new PostMetaField('some_other_key', '1');
        $this->shouldThrow(\InvalidArgumentException::class)->duringAdd($field);
        $this->shouldThrow(\InvalidArgumentException::class)->duringRemove($field);
    }
    
    function it_sets_and_unsets_by_offset()
    {
        $field3 = new PostMetaField(self::META_KEY, '3');
        $this->offsetSet(2, $field3);
        $this->offsetGet(2)->shouldReturn($field3);
        $this->offsetUnset(2);
        $this->offsetGet(2)->shouldBe(null);
    }
    
    function it_return_an_iterator()
    {
        $this->getIterator()->shouldBeAnInstanceOf(\ArrayIterator::class);
        $this->getIterator()->shouldHaveCount(2);
    }
}
