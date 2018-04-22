<?php

namespace unit\Spark\Query;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Query\TermQueryBuilder;

class TermQueryBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TermQueryBuilder::class);
    }

    function it_filters_by_a_taxonomy()
    {
        $this->withTaxonomy('category')->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn(['taxonomy' => 'category']);
    }
    
    function it_filters_query_to_find_all_records()
    {
        $this->all()->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn(['hide_empty' => false]);
    }
    
    function it_filters_query_with_limit_parameter()
    {
        $this->limit(10)->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn(['number' => 10]);
    }

}
