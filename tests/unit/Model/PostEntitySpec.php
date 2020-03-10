<?php

namespace unit\Spark\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Support\Collection;
use Spark\Model\PostEntity;
use Spark\Model\Taxonomy\Tag;
use Spark\Model\Taxonomy\Category;
use Spark\Model\Values\Permalink;
use Spark\Model\Values\PostDate;
use Spark\Model\Values\PostMetaField;
use Spark\Model\Values\Slug;
use Spark\Model\Values\TermMetaField;

class PostEntitySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PostEntity::class);
    }
    
    function let()
    {
        $this->beConstructedWith(123);
        $post = new \WP_Post(new \stdClass());
        $this->__set('wp_post', $post);
        $this->__set('slug', new Slug('some-post'));
        $this->setMetadata(new PostMetaField( 'meta_key1', '1' ));
        $this->setMetadata(new PostMetaField( 'meta_key2', '2' ));
    }
    
    function it_gets_the_unique_id()
    {
        $this->getId()->shouldReturn(123);
    }

    function it_gets_the_registry_key()
    {
        $this::getRegistryKey()->shouldReturn(false);
    }

    function it_gets_the_post_type()
    {
        $this->getPostType()->shouldReturn('post');
    }
    
    function it_gets_a_property()
    {
        $this->__get('meta_key0')->shouldBe(null);
        $this->__get('slug')->shouldBeLike('some-post');
        $field = new PostMetaField('meta_key1', '1');
        $this->__get('meta_key1')->shouldBeLike($field);
        $this->__get('post_modified_gmt')->shouldReturn('0000-00-00 00:00:00');
    }
    
    function it_sets_a_property()
    {
        $slug = new Slug('some-post-2');
        $this->__set('slug', $slug);
        $this->__get('slug')->shouldReturn($slug);
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
        $this->getPermalink()->shouldBeLike('http://test.com');
    }

    function it_checks_if_property_is_set()
    {
        $this->__isset('nonexistent_field')->shouldBe(false);
        $this->__isset('published_date')->shouldBe(false);
        $this->__set('published_date', new PostDate('2018-04-21 12:00:00'));
        $this->__isset('published_date')->shouldBe(true);
        $this->__isset('meta_key1')->shouldBe(true);
        $this->__set('meta_key1', null);
        $this->__isset('meta_key1')->shouldBe(false);
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

    function it_gets_all_the_terms()
    {
        $Collection = $this->it_sets_up_a_term_collection();
        $this->setTermsReference(function() use ($Collection) {
            return $Collection;
        });
        $this->__isset('terms')->shouldBe(false);

        $this->getTerms()->shouldReturn($Collection);
    }

    function it_gets_the_terms_of_a_specific_taxonomy()
    {
        $Collection = $this->it_sets_up_a_term_collection();
        $this->setTermsReference(function() use ($Collection) {
            return $Collection;
        });
        $Collection2 = new Collection([new Category(123), new Category(124)]);
        $this->getTermsForTaxonomy('category')->shouldBeLike($Collection2);
    }

    private function it_sets_up_a_term_collection()
    {
        return new Collection([
            new Category(123), new Category(124),
            new Tag(456), new Tag(457)
        ]);
    }
}
