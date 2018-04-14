<?php

namespace unit\Spark\Repository;

use Spark\Model\EntityCollection;
use Spark\Model\PostType\Post;
use Spark\Support\Entity\PostFactory;
use Spark\Repository\PostTypeRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Support\Query\PostTypeQueryBuilder;

class PostTypeRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PostTypeRepository::class);
    }

    function let(PostTypeQueryBuilder $Query, PostFactory $Factory)
    {
        $this->beConstructedWith($Query, $Factory);
    }

    function it_gets_one_post_with_id(PostFactory $Factory, $functions)
    {
        $post_arr = [
            'ID' => 123, 'post_type' => 'post', 'post_status' => 'publish'
        ];
        $post = new \WP_Post((object)$post_arr);
        $functions->get_post(123)->willReturn($post);
        $functions->get_post_meta(123)->willReturn([]);
        $Post = new Post(123);
        $Factory->createFromWPPost($post, [])->willReturn($Post);
        $this->findById(123)->shouldReturn($Post);
    }

    function it_queries_and_gets_one_post(PostTypeQueryBuilder $Query, PostFactory $Factory, $functions)
    {
        $post_arr = [
            'ID' => 123, 'post_type' => 'post', 'post_status' => 'publish'
        ];
        $post = new \WP_Post((object)$post_arr);
        $Query->one()->shouldBeCalled();
        $Query->build()->willReturn(['category_name' => 'video', 'posts_per_page' => 1]);
        $functions->get_posts(
            ['category_name' => 'video', 'posts_per_page' => 1]
        )->willReturn([$post]);
        $functions->get_post_meta(123)->willReturn([]);
        $Post = new Post(123);
        $Factory->createFromWPPost($post, [])->willReturn($Post);
        $this->findOne(['category_name' => 'video'])->shouldReturn($Post);
    }

    function it_queries_and_gets_multiple_posts(PostTypeQueryBuilder $Query, PostFactory $Factory, $functions)
    {
        $post1_arr = ['ID' => 123, 'post_type' => 'post', 'post_status' => 'publish'];
        $post2_arr = ['ID' => 456, 'post_type' => 'post', 'post_status' => 'publish'];
        $post1 = new \WP_Post((object)$post1_arr);
        $post2 = new \WP_Post((object)$post2_arr);
        $Query->where(['category_name' => 'video'])->shouldBeCalled();
        $Query->build()->willReturn(['category_name' => 'video']);
        $functions->get_posts(
            ['category_name' => 'video']
        )->willReturn([$post1, $post2]);
        $functions->get_post_meta(Argument::type('int'))->will(function($args) {
            return $args[0] == 123 ? ['meta_key1' => '1', 'meta_key2' => '2'] : ['meta_key1' => '3', 'meta_key2' => '4'];
        });
        $Post1 = new Post(123);
        $Post2 = new Post(456);
        $Factory->createFromWPPost($post1, ['meta_key1' => '1', 'meta_key2' => '2'])->willReturn($Post1);
        $Factory->createFromWPPost($post2, ['meta_key1' => '3', 'meta_key2' => '4'])->willReturn($Post2);
        $Collection = new EntityCollection([$Post1, $Post2]);
        $this->find(['category_name' => 'video'])->shouldBeLike($Collection);
    }
}
