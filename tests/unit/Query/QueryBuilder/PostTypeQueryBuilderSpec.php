<?php

namespace unit\Spark\Query\QueryBuilder;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Model\PostType\Post;
use Spark\Model\PostType\Page;
use Spark\Query\SubQuery;
use Spark\Model\Collection;

class PostTypeQueryBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Query\QueryBuilder\PostTypeQueryBuilder');
    }
    
    function let($functions)
    {
        $this->beConstructedWith(Post::class);
    }
    
    function it_resets_the_query_and_model_class()
    {
        $this->where(['something' => 'somevalue']);
        $this->getParameters()->shouldReturn(['post_type' => 'post', 'something' => 'somevalue']);
        $this->reset(Page::class)->shouldReturn($this->getWrappedObject());
        $this->getParameters()->shouldReturn(['post_type' => 'page']);
        $this->shouldThrow(\InvalidArgumentException::class)->duringReset('not_a_model_class');
    }
    
    function it_filters_query_to_find_all_posts()
    {
        $this->findAll()->shouldReturn($this->getWrappedObject());
        $this->getParameters()->shouldReturn(['post_type' => 'post', 'posts_per_page' => -1]);
    }
    
    function it_filters_query_to_find_one_post()
    {
        $this->findOne()->shouldReturn($this->getWrappedObject());
        $this->getParameters()->shouldReturn(['post_type' => 'post', 'posts_per_page' => 1]);
    }
    
    function it_filters_query_with_any_query_parameters()
    {
        $this->where(['category_name' => 'video'])->shouldReturn($this->getWrappedObject());
        $this->getParameters()->shouldReturn(['post_type' => 'post', 'category_name' => 'video']);
    }
    
    function it_filters_query_with_orderby_parameter()
    {
        $this->orderBy('date ASC, title DESC')->shouldReturn($this->getWrappedObject());
        $this->getParameters()->shouldReturn(
            ['post_type' => 'post', 'orderby' => ['date', 'title'], 'order' => ['ASC', 'DESC']]
        );
    }
    
    function it_filters_query_with_limit_parameter()
    {
        $this->limit(10)->shouldReturn($this->getWrappedObject());
        $this->getParameters()->shouldReturn(['post_type' => 'post', 'posts_per_page' => 10]);
    }
    
    function it_filters_query_with_pagination_parameter()
    {
        $this->page(3)->shouldReturn($this->getWrappedObject());
        $this->getParameters()->shouldReturn(['post_type' => 'post', 'paged' => 3]);
    }
    
    function it_filters_query_with_record_offset_parameter()
    {
        $this->offset(5)->shouldReturn($this->getWrappedObject());
        $this->getParameters()->shouldReturn(['post_type' => 'post', 'offset' => 5]);
    }
    
    function it_filters_query_with_a_subquery(SubQuery $subquery)
    {
        $subquery->getQueryKey()->willReturn('meta_query');
        $subquery->build()->willReturn('meta query array');
        $this->withQuery($subquery)->shouldReturn($this->getWrappedObject());
        $this->getParameters()->shouldReturn(
            ['post_type' => 'post', 'meta_query' => 'meta query array']
        );
    }
    
    function it_queries_and_gets_one_post($functions)
    {
        $post_arr = [
            'ID' => 123, 'post_type' => 'post', 'post_status' => 'publish'
        ];
        $post = new \WP_Post((object)$post_arr);
        $functions->get_posts(
            ['post_type' => 'post', 'category_name' => 'video', 'posts_per_page' => 1]
        )->willReturn([$post]);
        $this->getOne(['category_name' => 'video'])->shouldBeAnInstanceOf(Post::class);
    }
    
    function it_gets_one_post_with_id($functions)
    {
        $post_arr = [
            'ID' => 123, 'post_type' => 'post', 'post_status' => 'publish'
        ];
        $post = new \WP_Post((object)$post_arr);
        $functions->get_post(123)->willReturn($post);
        $this->get(123)->shouldBeAnInstanceOf(Post::class);
    }
    
    function it_queries_and_gets_multiple_posts($functions)
    {
        $post1_arr = ['ID' => 123, 'post_type' => 'post', 'post_status' => 'publish'];
        $post2_arr = ['ID' => 456, 'post_type' => 'post', 'post_status' => 'publish'];
        $post1 = new \WP_Post((object)$post1_arr);
        $post2 = new \WP_Post((object)$post2_arr);
        $functions->get_posts(
            ['post_type' => 'post', 'category_name' => 'video']
        )->willReturn([$post1, $post2]);
        $this->where(['category_name' => 'video']);
        $this->get()->shouldBeAnInstanceOf(Collection::class);
        $this->get()->shouldHaveCount(2);
        $this->getIterator()->shouldBeAnInstanceOf(\ArrayIterator::class);
        $this->getIterator()->shouldHaveCount(2);
    }

}
