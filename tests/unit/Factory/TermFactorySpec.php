<?php

namespace unit\Spark\Factory;

use Spark\Factory\TermFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Model\Taxonomy\Category;
use Spark\Model\Values;
use Spark\Support\Entity\EntityRegistry;

class TermFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TermFactory::class);
    }

    function let(EntityRegistry $Registry)
    {
        $this->beConstructedWith($Registry);
    }

    function it_creates_a_term(EntityRegistry $Registry)
    {
        $data = ['taxonomy' => 'category'];
        $Registry->getByKey('category')->willReturn(Category::class);
        $this->create($data)->shouldBeAnInstanceOf(Category::class);
    }

    function it_creates_a_term_from_a_wp_term(EntityRegistry $Registry)
    {
        $term_arr = [
            'term_id' => 123,
            'taxonomy' => 'category',
            'name' => 'term name',
        ];
        $term = new \WP_Term((object)$term_arr);
        $Registry->getByKey('category')->willReturn(Category::class);
        $Term = new Category(123);
        $Term->parent_id = $Term->post_count = 0;
        $Term->name = new Values\TermName('term name');
        $Term->description = new Values\TermDescription('');
        $Term->slug = new Values\Slug('');
        $Term->wp_term = $term;
        $Term->setMetadata(new Values\TermMetaField('key','value'));
        $this->createFromWPTerm($term, ['key' => 'value'])->shouldBeLike($Term);
    }

    function it_guards_against_unregistered_term_classes(
        EntityRegistry $Registry
    )
    {
        $data = ['taxonomy' => 'category'];
        $Registry->getByKey('category')->willReturn(false);
        $this->shouldThrow(\InvalidArgumentException::class)
             ->duringCreate($data);
    }
}
