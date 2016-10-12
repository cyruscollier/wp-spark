<?php

namespace unit\Spark\Extension\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Extension\Entity\Taxonomy;

class TaxonomySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Extension\Entity\Taxonomy');
    }
        
    function let()
    {
        $this->beAnInstanceOf(TaxonomyTest::class);
    }
}

class TaxonomyTest extends Taxonomy
{
    const NAME = 'test';
}