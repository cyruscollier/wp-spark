<?php

namespace unit\Spark\Model\ActiveRecord\PostType;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Query\QueryBuilder\PostTypeQueryBuilder;
use Interop\Container\ContainerInterface;
use DI\FactoryInterface;
use Spark\Model\ActiveRecord\PostType\Post;

class PostSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Model\ActiveRecord\PostType\Post');
    }
    
    function it_returns_a_query_builder(
        FactoryInterface $Factory,
        PostTypeQueryBuilder $PostTypeQueryBuilder
    )
    {
        $Factory->make(PostTypeQueryBuilder::class, ['model_class' => Post::class])
                ->willReturn($PostTypeQueryBuilder);
        $this->query($Factory)->shouldReturn($PostTypeQueryBuilder);
    }
    
    function it_calls_query_builder_methods_dynamically()
    {
        $QueryBuilder = new PostTypeQueryBuilder(Post::class);
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
