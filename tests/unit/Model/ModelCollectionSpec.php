<?php

namespace unit\Spark\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Model\PostType\Post;
use Spark\Model\Taxonomy\Category;

class ModelCollectionSpec extends ObjectBehavior
{
    protected $post1;
    protected $post2;
    
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Model\ModelCollection');
    }
    
    function let()
    {
        $this->post1 = new Post;
        $this->post2 = new Post;
        $this->beConstructedWith([$this->post1, $this->post2]);
    }
    
    function it_sets_an_item_by_offset()
    {
        $post3 = new Post;
        $this->offsetSet(0, $post3);
        $this->offsetGet(0)->shouldReturn($post3);
        $post4 = new Post;
        $this->offsetSet(null, $post4);
        $this->offsetGet(2)->shouldReturn($post4);
    }
    
    function it_unsets_an_item_by_offset()
    {
        $this->offsetUnset(1);
        $this->offsetExists(1)->shouldBe(false);
    }
    
    function it_adds_an_item()
    {
        $post3 = new Post;
        $this->add($post3)->shouldReturn($this->getWrappedObject());
        $this->offsetExists(2)->shouldBe(true);
        $this->offsetGet(2)->shouldReturn($post3);
        $this->shouldHaveCount(3);
        $this->shouldThrow(\InvalidArgumentException::class)->duringAdd(new Category());
    }
    
    function it_removes_an_item()
    {
        $this->remove($this->post2)->shouldReturn($this->getWrappedObject());
        $this->offsetExists(1)->shouldBe(false);
        $this->shouldHaveCount(1);
    }
    
    function it_return_an_iterator()
    {
        $this->getIterator()->shouldBeAnInstanceOf(\ArrayIterator::class);
        $this->getIterator()->shouldHaveCount(2);
    }
}
