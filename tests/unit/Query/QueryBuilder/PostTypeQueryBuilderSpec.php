<?php

namespace unit\Spark\Query\QueryBuilder;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Model\PostType\Post;

class PostTypeQueryBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Query\QueryBuilder\PostTypeQueryBuilder');
    }
    
    function let()
    {
        $this->beConstructedWith(Post::class);
    }
}
