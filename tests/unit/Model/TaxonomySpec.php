<?php

namespace unit\Spark\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Model\Values\TermCompositeId;
use Spark\Model\Values\TermMetaField;
use Spark\Model\Values\TermName;

class TaxonomySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Model\Taxonomy');
    }
    
    function let()
    {
        $this->beConstructedWith(123);
        $term = new \WP_Term((object)['name' => 'term name', 'taxonomy' => 'category']);
        $this->__set('wp_term', $term);
        $this->setName(new TermName('term name'));
        $this->setMetadata(new TermMetaField( 'meta_key1', '1' ));
        $this->setMetadata(new TermMetaField( 'meta_key2', '2' ));
    }
    
    function it_gets_the_unique_id()
    {
        $this->getId()->shouldReturn(123);
    }

    function it_gets_the_registry_key()
    {
        $this::getRegistryKey()->shouldReturn(false);
    }

    function it_gets_the_taxonomy()
    {
        $this->getTaxonomy()->shouldReturn('category');
        $this->__get('taxonomy')->shouldReturn('category');
    }
    
    function it_gets_a_property()
    {
        $name = (new TermName('term name'))->addCompositeId(new TermCompositeId(123, 'category'));
        $this->__get('name')->shouldBeLike($name);
        $field = new TermMetaField('meta_key1', '1');
        $this->__get('meta_key1')->shouldBeLike($field);
    }
    
    function it_sets_a_property()
    {
        $new_name = new TermName('new term name');
        $new_name2 = $new_name->addCompositeId(new TermCompositeId(123, 'category'));
        $this->__set('name', $new_name);
        $this->__get('name')->shouldBeLike($new_name2);
        $field = new TermMetaField('something_random', 'abc');
        $this->__set('something_random', 'abc');
        $this->__get('something_random')->shouldBeLike($field);
    }

}
