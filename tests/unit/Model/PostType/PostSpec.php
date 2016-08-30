<?php

namespace unit\Spark\Model\PostType;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Model\Values\PostMetaField;
use Spark\Model\Values\PostTitle;
use Spark\Model\Values\PostStatus;

class PostSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Model\PostType\Post');
    }
    
    function let()
    {
        $post_arr = [
            'ID' => 123, 'post_type' => 'post', 'post_status' => 'publish',
        ];
        $post = new \WP_Post((object)$post_arr);
        $metadata = [new PostMetaField( 'meta_key1', '1' ), new PostMetaField( 'meta_key2', '2' )];
        $this->beConstructedThrough('createFromPost', [$post, $metadata]);
    }
    
    function it_gets_the_unique_id()
    {
        $this->getId()->shouldReturn(123);
    }
    
    function it_gets_a_property()
    {
        $post_status = new PostStatus('publish');
        $this->__get('status')->shouldBeLike($post_status);
        $this->__get('menu_order')->shouldReturn(0);
        $field = new PostMetaField('meta_key1', '1');
        $this->__get('meta_key1')->shouldBeLike($field);
    }
    
    function it_sets_a_property()
    {
        $post_status = new PostStatus('draft');
        $this->__set('status', $post_status);
        $this->__get('status')->shouldReturn($post_status);
        $field = new PostMetaField('something_random', 'abc');
        $this->__set('something_random', 'abc');
        $this->__get('something_random')->shouldBeLike($field);
    }
    
    function it_gets_the_metadata_type()
    {
        $this->getMetadataType()->shouldReturn('post');
    }
    
    function it_creates_a_metadata_field()
    {
        $field = new PostMetaField('some_key', 'some_value');
        $this->createMetadataField('some_key', 'some_value')->shouldBeLike($field);
    }
    
    function it_sets_a_metadata_field()
    {
        $field = new PostMetaField('some_key', 'some_value');
        $this->setMetadata($field);
        $this->__get('some_key')->shouldReturn($field);
    }
}
