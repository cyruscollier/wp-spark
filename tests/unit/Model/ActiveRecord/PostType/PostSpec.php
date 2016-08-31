<?php

namespace unit\Spark\Model\ActiveRecord\PostType;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Query\QueryBuilder\PostTypeQueryBuilder;

class PostSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Model\ActiveRecord\PostType\Post');
    }
    
    function it_returns_a_query_builder()
    {
        $this->query()->shouldReturnAnInstanceOf(PostTypeQueryBuilder::class);
    }
    
    function it_calls_query_builder_methods_dynamically()
    {
        $QueryBuilder = new PostTypeQueryBuilder(get_class($this->getWrappedObject()));
        $QueryBuilder->limit(5);
        $this->__call('limit', [5])->shouldBeLike($QueryBuilder);
    }
    
    function it_calls_query_builder_methods_statically()
    {
        $subject = $this->getWrappedObject();
        $QueryBuilder = $subject::__callStatic('limit',[5]);
        $this->limit(5)->shouldBeLike($QueryBuilder);
    }
}
