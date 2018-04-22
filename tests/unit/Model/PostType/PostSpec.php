<?php

namespace unit\Spark\Model\PostType;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Model\Values\Permalink;
use Spark\Model\Values\PostDate;
use Spark\Model\Values\PostMetaField;
use Spark\Model\Values\PostTitle;
use Spark\Model\Values\PostStatus;
use Spark\Model\Values\TermMetaField;

class PostSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Model\PostType\Post');
    }
    
    function let()
    {
        $this->beConstructedWith(123);
        $this->setStatus(PostStatus::published());
        $this->setMetadata(new PostMetaField( 'meta_key1', '1' ));
        $this->setMetadata(new PostMetaField( 'meta_key2', '2' ));
    }
    
    function it_gets_the_unique_id()
    {
        $this->getId()->shouldReturn(123);
    }

    function it_gets_the_registry_key()
    {
        $this::getRegistryKey()->shouldReturn('post');
    }
    
    function it_gets_a_property()
    {
        $this->__get('meta_key0')->shouldBe(null);
        $post_status = PostStatus::published();
        $this->__get('status')->shouldBeLike($post_status);
        $field = new PostMetaField('meta_key1', '1');
        $this->__get('meta_key1')->shouldBeLike($field);
    }
    
    function it_sets_a_property()
    {
        $post_status = PostStatus::draft();
        $this->__set('status', $post_status);
        $this->__get('status')->shouldReturn($post_status);
        $field = new PostMetaField('something_random', 'abc');
        $this->__set('something_random', 'abc');
        $this->__get('something_random')->shouldBeLike($field);
        $field2 = $field->update('def');
        $this->__set('something_random', 'def');
        $this->__get('something_random')->shouldBeLike($field2);
    }

    function it_sets_a_permalink()
    {
        $permalink = new Permalink('http://test.com');
        $this->setPermalink($permalink);
        $this->getPermalink()->shouldBe($permalink);
    }

    function it_checks_if_property_is_set()
    {
        $this->__isset('nonexistent_field')->shouldBe(false);
        $this->__isset('published_date')->shouldBe(false);
        $post_date = new PostDate('2018-04-21 12:00:00');
        $this->__set('published_date', $post_date);
        $this->__isset('published_date')->shouldBe(true);
    }
    
    function it_creates_a_metadata_field()
    {
        $field = new PostMetaField('some_key', 'some_value');
        $this->__set('some_key', 'some_value');
        $this->__get('some_key')->shouldBeLike($field);
    }

    function it_guards_against_settin_an_invalid_metadata_field()
    {
        $field = new TermMetaField('some_key', 'some_value');
        $this->shouldThrow(\InvalidArgumentException::class)
             ->duringSetMetadata($field);
    }
}
