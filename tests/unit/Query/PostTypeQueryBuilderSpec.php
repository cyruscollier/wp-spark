<?php

namespace unit\Spark\Query;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Support\Query\SubQuery;

class PostTypeQueryBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Query\PostTypeQueryBuilder');
    }
    
    function it_resets_the_query()
    {
        $this->where(['something' => 'somevalue'])
             ->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn(['something' => 'somevalue']);
        $this->reset()->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn([]);
    }
    
    function it_filters_query_to_find_all_records()
    {
        $this->all()->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn(['posts_per_page' => -1]);
    }
    
    function it_filters_query_to_find_one_record()
    {
        $this->one()->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn(['posts_per_page' => 1]);
    }
    
    function it_filters_query_with_merging_new_parameters()
    {
        $this->one();
        $this->where(['category_name' => 'video'])->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn(['posts_per_page' => 1, 'category_name' => 'video']);
    }
    
    function it_filters_query_with_orderby_parameter()
    {
        $this->orderBy('date ASC, title DESC')->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn(
            ['orderby' => ['date', 'title'], 'order' => ['ASC', 'DESC']]
        );
    }
    
    function it_filters_query_with_limit_parameter()
    {
        $this->limit(10)->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn(['posts_per_page' => 10]);
    }
    
    function it_filters_query_with_pagination_parameter()
    {
        $this->page(3)->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn(['paged' => 3]);
    }
    
    function it_filters_query_with_record_offset_parameter()
    {
        $this->offset(5)->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn(['offset' => 5]);
    }
    
    function it_filters_query_with_a_subquery(SubQuery $subquery)
    {
        $subquery->getQueryKey()->willReturn('meta_query');
        $subquery->build()->willReturn(['meta query array']);
        $this->withSubQuery($subquery)->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn(
            ['meta_query' => ['meta query array']]
        );
    }
}
