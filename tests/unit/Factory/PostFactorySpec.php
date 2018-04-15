<?php

namespace unit\Spark\Factory;

use Spark\Factory\PostFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Model\PostType\Post;
use Spark\Model\Values;
use Spark\Support\Entity\EntityRegistry;

class PostFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PostFactory::class);
    }

    function let(EntityRegistry $Registry)
    {
        $this->beConstructedWith($Registry);
    }

    function it_creates_a_post(EntityRegistry $Registry)
    {
        $data = ['post_type' => 'post'];
        $Registry->getByKey('post')->willReturn(Post::class);
        $this->create($data)->shouldBeAnInstanceOf(Post::class);
    }

    function it_creates_a_post_from_a_wp_post(EntityRegistry $Registry)
    {
        $post_arr = [
            'ID' => 123,
            'post_type' => 'post',
            'status' => 'publish',
            'post_date' => '2018-04-15 00:00:00',
            'post_modified' => '2018-04-15 00:00:00'
        ];
        $post = new \WP_Post((object)$post_arr);
        $Registry->getByKey('post')->willReturn(Post::class);
        $Post = new Post(123);
        $Post->parent_id = $Post->author_id = 0;
        $Post->title = new Values\PostTitle('');
        $Post->content = new Values\PostContent('');
        $Post->excerpt = new Values\PostExcerpt('');
        $Post->slug = new Values\Slug('');
        $Post->status = Values\PostStatus::published();
        $Post->published_date = new Values\PostDate('2018-04-15 00:00:00');
        $Post->modified_date = new Values\PostModifiedDate('2018-04-15 00:00:00');
        $Post->wp_post = $post;
        $Post->setMetadata(new Values\PostMetaField('key','value'));
        $this->createFromWPPost($post, ['key' => 'value'])->shouldBeLike($Post);
    }

    function it_guards_against_unregistered_post_classes(
        EntityRegistry $Registry
    )
    {
        $data = ['post_type' => 'post'];
        $Registry->getByKey('post')->willReturn(false);
        $this->shouldThrow(\InvalidArgumentException::class)
             ->duringCreate($data);
    }
}
