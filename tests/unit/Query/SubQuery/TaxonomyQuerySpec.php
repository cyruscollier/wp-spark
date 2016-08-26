<?php

namespace unit\Spark\Query\SubQuery;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaxonomyQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Query\SubQuery\TaxonomyQuery');
    }
    
    function it_is_a_taxonomy_query()
    {
        $this->getQueryKey()->shouldReturn('tax_query');
    }
    
    function it_adds_a_clause_with_defaults()
    {
        $this->add('test_taxonomy', 'test_term')->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn([
            ['taxonomy' => 'test_taxonomy', 'terms' => ['test_term'], 
             'operator' => 'IN', 'field' => 'slug']
        ]);
    }
    
    function it_adds_a_clause_with_operator_and_field()
    {
        $this->add('test_taxonomy', [100, 101], 'NOT IN', 'term_id')
             ->shouldReturn($this->getWrappedObject());
        $this->build()->shouldReturn([
            ['taxonomy' => 'test_taxonomy', 'terms' => [100, 101], 
             'operator' => 'NOT IN', 'field' => 'term_id']
        ]);
    }
    
    function it_joins_multiple_clauses()
    {
        $this->add('test_taxonomy1', 'test_term1');
        $this->add('test_taxonomy2', 'test_term2');
        $this->build()->shouldReturn([
            ['taxonomy' => 'test_taxonomy1', 'terms' => ['test_term1'], 
             'operator' => 'IN', 'field' => 'slug'],
            ['taxonomy' => 'test_taxonomy2', 'terms' => ['test_term2'], 
             'operator' => 'IN', 'field' => 'slug'],
            'relation' => 'AND'
        ]);
    }
}
