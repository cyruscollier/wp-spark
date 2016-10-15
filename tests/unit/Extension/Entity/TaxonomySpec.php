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
    
    function it_registers_a_taxonomy($functions)
    {
        $taxonomy = new \stdClass();
        $functions->register_taxonomy('test', ['test_postype'], Argument::type('array'))
                  ->shouldBeCalled();
        $functions->register_taxonomy_for_object_type('test', ['test_postype'])
                  ->shouldBeCalled();
        $functions->get_taxonomy('test')->willReturn($taxonomy);
        $this->init()->shouldReturn($taxonomy);
    }
    
    function it_deregisters_a_taxonomy()
    {
        $GLOBALS['wp_taxonomies']['test'] = new \stdClass();
        $this->deregister()->shouldReturn(true);
        $this->deregister()->shouldReturn(false);
    }
    
    function it_checks_if_taxonomy_is_registered($functions)
    {
        $functions->taxonomy_exists('test')->willReturn(true);
        $this->isRegistered()->shouldReturn(true);
    }
}

class TaxonomyTest extends Taxonomy
{
    const NAME = 'test';
    
    protected $post_types = ['test_postype'];
}