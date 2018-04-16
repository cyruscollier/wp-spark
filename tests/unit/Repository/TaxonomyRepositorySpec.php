<?php

namespace unit\Spark\Repository;

use Spark\Model\EntityCollection;
use Spark\Model\PostType\Post;
use Spark\Model\Taxonomy\Category;
use Spark\Model\Values\PostDate;
use Spark\Model\Values\PostStatus;
use Spark\Query\DateQuery;
use Spark\Repository\TaxonomyRepository;
use Spark\Support\Entity\TermFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Support\Query\TaxonomyQueryBuilder;

class TaxonomyRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TaxonomyRepository::class);
    }

    function let(TaxonomyQueryBuilder $Query, TermFactory $Factory, $functions)
    {
        $this->beConstructedWith($Query, $Factory);
        $functions->get_term_link(Argument::type('WP_Term'))->willReturn('http://test.com/taxonomy/term');
    }

    function it_find_one_term_by_id(TermFactory $Factory, $functions)
    {
        $term = $this->it_sets_up_a_wp_term();
        $functions->get_term(123, '')->willReturn($term);
        $Term = $this->it_sets_up_one_term($term, $Factory, $functions);
        $this->findById(123)->shouldReturn($Term);
    }

    function it_finds_one_term(TaxonomyQueryBuilder $Query, TermFactory $Factory, $functions)
    {
        $params = ['taxonomy' => 'category', 'number' => 1];
        $term = $this->it_sets_up_a_wp_term();
        $Query->one()->shouldBeCalled();
        $Query->build()->willReturn($params);
        $functions->get_terms($params)->willReturn([$term]);
        $Term = $this->it_sets_up_one_term($term, $Factory, $functions);
        $this->findOne(['taxonomy' => 'category'])->shouldReturn($Term);
    }

    function it_finds_multiple_terms(TaxonomyQueryBuilder $Query, TermFactory $Factory, $functions)
    {
        $params = ['taxonomy' => 'category'];
        $Query->where($params)->shouldBeCalled();
        $Query->build()->willReturn($params);
        $Collection = $this->it_sets_up_a_collection($params, $Factory, $functions);
        $this->find(['taxonomy' => 'category'])->shouldBeLike($Collection);
    }

    function it_finds_all_terms(TaxonomyQueryBuilder $Query, TermFactory $Factory, $functions)
    {
        $params = ['number' => -1];
        $Query->all()->shouldBeCalled();
        $Query->build()->willReturn($params);
        $Collection = $this->it_sets_up_a_collection($params, $Factory, $functions);
        $this->findAll()->shouldBeLike($Collection);
    }

    private function it_sets_up_a_wp_term($id = 123)
    {
        $term_arr = [
            'term_id' => $id, 'taxonomy' => 'category'
        ];
        return new \WP_Term((object)$term_arr);
    }

    private function it_sets_up_one_term($term, $Factory, $functions)
    {
        $functions->get_term_meta(123)->willReturn([]);
        $Term = new Category(123);
        $Factory->createFromWPTerm($term, [])->willReturn($Term);
        return $Term;
    }

    private function it_sets_up_a_collection($params, TermFactory $Factory, $functions)
    {
        $term1 = $this->it_sets_up_a_wp_term(123);
        $term2 = $this->it_sets_up_a_wp_term(456);
        $functions->get_terms($params)->willReturn([$term1, $term2]);
        $functions->get_term_meta(Argument::type('int'))->will(function($args) {
            return $args[0] == 123 ? ['meta_key1' => '1', 'meta_key2' => '2'] : ['meta_key1' => '3', 'meta_key2' => '4'];
        });
        $Term1 = new Category(123);
        $Term2 = new Category(456);
        $Factory->createFromWPTerm($term1, ['meta_key1' => '1', 'meta_key2' => '2'])->willReturn($Term1);
        $Factory->createFromWPTerm($term2, ['meta_key1' => '3', 'meta_key2' => '4'])->willReturn($Term2);
        return new EntityCollection([$Term1, $Term2]);
    }
}
