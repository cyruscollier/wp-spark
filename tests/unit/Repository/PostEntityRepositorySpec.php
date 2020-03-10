<?php

namespace unit\Spark\Repository;

use Spark\Support\Collection;
use Spark\Model\PostType\Post;
use Spark\Model\Values\PostDate;
use Spark\Model\Values\PostStatus;
use Spark\Query\DateQuery;
use Spark\Support\Entity\PostFactory;
use Spark\Repository\PostEntityRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Support\Entity\TermEntityRepository;
use Spark\Support\Query\PostQueryBuilder;
use Spark\Repository\PostType\PostRepository;

class PostEntityRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PostEntityRepository::class);
    }

    function let(PostQueryBuilder $Query, PostFactory $Factory, TermEntityRepository $Repository, $functions)
    {
        $this->beConstructedWith($Query, $Factory, $Repository);
        $functions->get_permalink(Argument::type('int'))->willReturn('http://test.com/post');
    }

    function it_find_one_post_by_id(PostFactory $Factory, $functions)
    {
        $post = $this->it_sets_up_a_wp_post();
        $functions->get_post(123)->willReturn($post);
        $Post = $this->it_sets_up_one_post($post, $Factory, $functions);
        $this->findById(123)->shouldReturn($Post);
    }

    function it_finds_one_post(PostQueryBuilder $Query, PostFactory $Factory, $functions)
    {
        $params = ['category_name' => 'video', 'posts_per_page' => 1];
        $post = $this->it_sets_up_a_wp_post();
        $Query->one()->shouldBeCalled();
        $Query->build()->willReturn($params);
        $functions->get_posts($params)->willReturn([$post]);
        $Post = $this->it_sets_up_one_post($post, $Factory, $functions);
        $this->findOne(['category_name' => 'video'])->shouldReturn($Post);
    }

    function it_finds_multiple_posts(PostQueryBuilder $Query, PostFactory $Factory, $functions)
    {
        $params = ['category_name' => 'video'];
        $Query->where($params)->shouldBeCalled();
        $Query->build()->willReturn($params);
        $Collection = $this->it_sets_up_a_collection($params, $Factory, $functions);
        $this->find(['category_name' => 'video'])->shouldBeLike($Collection);
    }

    function it_guards_against_finding_one_by_id_not_matching_explicit_post_type(
        PostQueryBuilder $Query, PostFactory $Factory, TermEntityRepository $Repository, $functions
    ) {
        $this->beAnInstanceOf(PostRepository::class);
        $this->beConstructedWith($Query, $Factory, $Repository);
        $post = $this->it_sets_up_a_wp_post();
        $post->post_type = 'some_other_post_type';
        $functions->get_post(123)->willReturn($post);
        $functions->reveal();
        $this->shouldThrow(\InvalidArgumentException::class)
             ->duringFindById(123);
    }

    function it_finds_posts_with_explicit_post_type(
        PostQueryBuilder $Query, PostFactory $Factory, TermEntityRepository $Repository, $functions
    ) {
        $this->beAnInstanceOf(PostRepository::class);
        $this->beConstructedWith($Query, $Factory, $Repository);
        $params = ['category_name' => 'video'];
        $Query->where($params)->shouldBeCalled();
        $params['post_type'] = 'post';
        $Query->withPostType(['post'])->shouldBeCalled();

        $Query->build()->willReturn($params);
        $Collection = $this->it_sets_up_a_collection($params, $Factory, $functions);
        $this->find(['category_name' => 'video'])->shouldBeLike($Collection);
    }

    function it_finds_all_posts(PostQueryBuilder $Query, PostFactory $Factory, $functions)
    {
        $params = ['posts_per_page' => -1];
        $Query->all()->shouldBeCalled();
        $Query->build()->willReturn($params);
        $Collection = $this->it_sets_up_a_collection($params, $Factory, $functions);
        $this->findAll()->shouldBeLike($Collection);
    }

    function it_finds_posts_by_an_author(PostQueryBuilder $Query, PostFactory $Factory, $functions)
    {
        $params = ['author' => 10];
        $Query->where($params)->shouldBeCalled();
        $Query->build()->willReturn($params);
        $Collection = $this->it_sets_up_a_collection($params, $Factory, $functions);
        $this->findByAuthor(10)->shouldBeLike($Collection);
    }

    function it_finds_posts_with_a_status(PostQueryBuilder $Query, PostFactory $Factory, $functions)
    {
        $params = ['post_status' => 'draft'];
        $Query->where($params)->shouldBeCalled();
        $Query->build()->willReturn($params);
        $Collection = $this->it_sets_up_a_collection($params, $Factory, $functions);
        $this->findWithStatus(PostStatus::draft())->shouldBeLike($Collection);
    }

    function it_finds_posts_with_a_published_date(PostQueryBuilder $Query, PostFactory $Factory, $functions)
    {
        $params = ['date_query' => [[
            'year' => 2018,
            'month' => 4,
            'day' => 15,
            'compare' => '=',
            'column' => 'post_date'
        ]]];
        $DateQuery = new DateQuery();
        $Query->withSubQuery($DateQuery->add('2018-04-15'))->shouldBeCalled();
        $Query->build()->willReturn($params);
        $Collection = $this->it_sets_up_a_collection($params, $Factory, $functions);
        $Date = new PostDate('2018-04-15');
        $this->findPublishedOn($Date)->shouldBeLike($Collection);
    }

    function it_finds_posts_published_before_a_date(PostQueryBuilder $Query, PostFactory $Factory, $functions)
    {
        $params = ['date_query' => [[
            'before' => '2018-04-15 00:00:00'
        ]]];
        $Query->withSubQuery(Argument::type(DateQuery::class))->shouldBeCalled();
        $Query->build()->willReturn($params);
        $Collection = $this->it_sets_up_a_collection($params, $Factory, $functions);
        $Date = new PostDate('2018-04-15');
        $this->findPublishedBefore($Date)->shouldBeLike($Collection);
    }

    function it_finds_posts_published_after_a_date(PostQueryBuilder $Query, PostFactory $Factory, $functions)
    {
        $params = ['date_query' => [[
            'after' => '2018-04-15 00:00:00'
        ]]];
        $Query->withSubQuery(Argument::type(DateQuery::class))->shouldBeCalled();
        $Query->build()->willReturn($params);
        $Collection = $this->it_sets_up_a_collection($params, $Factory, $functions);
        $Date = new PostDate('2018-04-15');
        $this->findPublishedAfter($Date)->shouldBeLike($Collection);
    }

    private function it_sets_up_a_wp_post($id = 123)
    {
        $post_arr = [
            'ID' => $id, 'post_type' => 'post', 'post_status' => 'publish'
        ];
        return new \WP_Post((object)$post_arr);
    }

    private function it_sets_up_one_post($post, $Factory, $functions)
    {
        $functions->get_post_meta(123)->willReturn([]);
        $Post = new Post(123);
        $Factory->createFromWPPost($post, [])->willReturn($Post);
        return $Post;
    }

    private function it_sets_up_a_collection($params, PostFactory $Factory, $functions)
    {
        $post1 = $this->it_sets_up_a_wp_post(123);
        $post2 = $this->it_sets_up_a_wp_post(456);
        $functions->get_posts($params)->willReturn([$post1, $post2]);
        $functions->get_post_meta(Argument::type('int'))->will(function($args) {
            return $args[0] == 123 ? ['meta_key1' => '1', 'meta_key2' => '2'] : ['meta_key1' => '3', 'meta_key2' => '4'];
        });
        $Post1 = new Post(123);
        $Post2 = new Post(456);
        $Factory->createFromWPPost($post1, ['meta_key1' => '1', 'meta_key2' => '2'])->willReturn($Post1);
        $Factory->createFromWPPost($post2, ['meta_key1' => '3', 'meta_key2' => '4'])->willReturn($Post2);
        return new Collection([$Post1, $Post2]);
    }
}

