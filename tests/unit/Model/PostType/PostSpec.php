<?php

namespace unit\Spark\Model\PostType;

use Spark\Model\PostType\Post;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Post::class);
    }

    function it_gets_the_registry_key()
    {
        $this::getRegistryKey()->shouldReturn('post');
    }
}
