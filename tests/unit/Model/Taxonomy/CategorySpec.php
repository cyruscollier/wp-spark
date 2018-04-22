<?php

namespace unit\Spark\Model\Taxonomy;

use Spark\Model\Taxonomy\Category;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CategorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Category::class);
    }

    function it_gets_the_registry_key()
    {
        $this::getRegistryKey()->shouldReturn('category');
    }
}
