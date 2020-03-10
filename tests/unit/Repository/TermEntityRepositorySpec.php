<?php

namespace unit\Spark\Repository;

use Spark\Support\Collection;
use Spark\Model\PostType\Post;
use Spark\Model\Taxonomy\Category;
use Spark\Model\Values\PostDate;
use Spark\Model\Values\PostStatus;
use Spark\Model\Values\TermCompositeId;
use Spark\Query\DateQuery;
use Spark\Repository\TermEntityRepository;
use Spark\Support\Entity\TermFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Support\Query\TermQueryBuilder;
use Spark\Repository\Taxonomy\CategoryRepository;

class TermEntityRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TermEntityRepository::class);
    }

    function let(TermQueryBuilder $Query, TermFactory $Factory, $functions)
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

    function it_find_one_term_by_term_composite_id(TermFactory $Factory, $functions)
    {
        $term = $this->it_sets_up_a_wp_term();
        $functions->get_term(123, 'category')->willReturn($term);
        $Term = $this->it_sets_up_one_term($term, $Factory, $functions);
        $this->findById(new TermCompositeId(123, 'category'))->shouldReturn($Term);
    }

    function it_finds_one_term(TermQueryBuilder $Query, TermFactory $Factory, $functions)
    {
        $params = ['taxonomy' => 'category', 'number' => 1];
        $term = $this->it_sets_up_a_wp_term();
        $Query->one()->shouldBeCalled();
        $Query->build()->willReturn($params);
        $functions->get_terms($params)->willReturn([$term]);
        $Term = $this->it_sets_up_one_term($term, $Factory, $functions);
        $this->findOne(['taxonomy' => 'category'])->shouldReturn($Term);
    }

    function it_finds_multiple_terms(TermQueryBuilder $Query, TermFactory $Factory, $functions)
    {
        $params = ['taxonomy' => 'category'];
        $Query->where($params)->shouldBeCalled();
        $Query->build()->willReturn($params);
        $Collection = $this->it_sets_up_a_collection($params, $Factory, $functions);
        $this->find(['taxonomy' => 'category'])->shouldBeLike($Collection);
    }

    function it_guards_against_finding_one_by_id_not_matching_explicit_taxonomy(
        TermQueryBuilder $Query, TermFactory $Factory, $functions
    ) {
        $this->beAnInstanceOf(CategoryRepository::class);
        $this->beConstructedWith($Query, $Factory);
        $term = $this->it_sets_up_a_wp_term();
        $term->taxonomy = 'some_other_taxonomy';
        $functions->get_term(123, '')->willReturn($term);
        $functions->reveal();
        $this->shouldThrow(\InvalidArgumentException::class)
             ->duringFindById(123);
    }

    function it_finds_terms_with_explicit_taxonomy(
        TermQueryBuilder $Query, TermFactory $Factory, $functions
    ) {
        $this->beAnInstanceOf(CategoryRepository::class);
        $this->beConstructedWith($Query, $Factory);
        $params = ['number' => 10];
        $Query->withTaxonomy(['category'])->shouldBeCalled();
        $Query->where($params)->shouldBeCalled();
        $params['taxonomy'] = 'category';
        $Query->build()->willReturn($params);
        $Collection = $this->it_sets_up_a_collection($params, $Factory, $functions);
        $this->find(['number' => 10])->shouldBeLike($Collection);
    }

    function it_finds_all_terms(TermQueryBuilder $Query, TermFactory $Factory, $functions)
    {
        $params = ['number' => -1];
        $Query->all()->shouldBeCalled();
        $Query->build()->willReturn($params);
        $Collection = $this->it_sets_up_a_collection($params, $Factory, $functions);
        $this->findAll()->shouldBeLike($Collection);
    }

    function it_finds_all_terms_in_a_taxonomy(TermQueryBuilder $Query, TermFactory $Factory, $functions)
    {
        $params = ['number' => -1];
        $Query->all()->shouldBeCalled();
        $Query->withTaxonomy('category')->shouldBeCalled();
        $params['taxonomy'] = 'category';
        $Query->build()->willReturn($params);
        $Collection = $this->it_sets_up_a_collection($params, $Factory, $functions);
        $this->findAll('category')->shouldBeLike($Collection);
    }

    function it_finds_terms_assigned_to_a_post(TermQueryBuilder $Query, TermFactory $Factory, $functions)
    {
        $Post = new Post(123);
        $params = ['object_ids' => [123]];
        $Query->where($params)->shouldBeCalled();
        $Query->build()->willReturn($params);
        $Collection = $this->it_sets_up_a_collection($params, $Factory, $functions);
        $this->findForPost($Post)->shouldBeLike($Collection);
    }

    function it_finds_terms_in_a_taxonomy_assigned_to_a_post(TermQueryBuilder $Query, TermFactory $Factory, $functions)
    {
        $Post = new Post(123);
        $params = ['object_ids' => [123]];
        $Query->where($params)->shouldBeCalled();
        $Query->withTaxonomy('category')->shouldBeCalled();
        $params['taxonomy'] = 'category';
        $Query->build()->willReturn($params);
        $Collection = $this->it_sets_up_a_collection($params, $Factory, $functions);
        $this->findForPost($Post, 'category')->shouldBeLike($Collection);
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
        return new Collection([$Term1, $Term2]);
    }
}
