<?php

namespace unit\Spark\Query;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Query\MetaQuery;
use Spark\Query\TaxonomyQuery;

class MetaQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Query\MetaQuery');
    }
    
    function it_is_a_meta_query()
    {
        $this->getQueryKey()->shouldReturn('meta_query');
    }
    
    function it_adds_a_clause_with_defaults()
    {
        $this->add('test_key', 'test_value')->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn([
            ['key' => 'test_key', 'value' => 'test_value', 'compare' => '=', 'type' => 'CHAR']
        ]);
    }
    
    function it_adds_a_clause_with_compare_and_type()
    {
        $this->add('test_key', 0, '>=', 'NUMERIC')->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn([
            ['key' => 'test_key', 'value' => 0, 'compare' => '>=', 'type' => 'NUMERIC']
        ]);
    }
    
    function it_adds_a_range_clause()
    {
        $this->addRange('test_key', 0, 10)->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn([
            ['key' => 'test_key', 'value' => [0, 10], 'compare' => 'BETWEEN', 'type' => 'NUMERIC']
        ]);
    }
    
    function it_joins_multiple_clauses()
    {
        $this->add('test_key1', 'test_value1');
        $this->add('test_key2', 'test_value2');
        $this->build()->shouldReturn([
            ['key' => 'test_key1', 'value' => 'test_value1', 'compare' => '=', 'type' => 'CHAR'],
            ['key' => 'test_key2', 'value' => 'test_value2', 'compare' => '=', 'type' => 'CHAR'],
            'relation' => 'AND'
        ]);
    }

    function it_adds_a_subquery()
    {
        $this->add('test_key1', 'test_value1');
        $Subquery = new MetaQuery('OR');
        $Subquery->add('test_key2', 'test_value2')
                 ->add('test_key3', 'test_value3');
        $this->addSubQuery($Subquery);
        $this->build()->shouldReturn([
            ['key' => 'test_key1', 'value' => 'test_value1', 'compare' => '=', 'type' => 'CHAR'],
            [
                ['key' => 'test_key2', 'value' => 'test_value2', 'compare' => '=', 'type' => 'CHAR'],
                ['key' => 'test_key3', 'value' => 'test_value3', 'compare' => '=', 'type' => 'CHAR'],
                'relation' => 'OR'
            ],
            'relation' => 'AND'
        ]);
    }

    function it_converts_a_subquery_to_base_if_no_base_query()
    {
        $Subquery = new MetaQuery('OR');
        $Subquery->add('test_key2', 'test_value2')
            ->add('test_key3', 'test_value3');
        $this->addSubQuery($Subquery);
        $this->build()->shouldReturn([
            ['key' => 'test_key2', 'value' => 'test_value2', 'compare' => '=', 'type' => 'CHAR'],
            ['key' => 'test_key3', 'value' => 'test_value3', 'compare' => '=', 'type' => 'CHAR'],
            'relation' => 'OR'
        ]);
    }

    function it_guards_against_mismatched_subquery_types()
    {
        $this->add('test_key1', 'test_value1');
        $Subquery = new TaxonomyQuery();
        $this->shouldThrow(\InvalidArgumentException::class)
             ->duringAddSubQuery($Subquery);
    }
}
