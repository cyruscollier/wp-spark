<?php

namespace unit\Spark\Model\Values;

use Spark\Model\Values\PostStatus;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostStatusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PostStatus::class);
    }

    function let()
    {
        $this->beConstructedThrough('published');
    }

    function it_guards_against_contructing_with_an_invalid_status()
    {
        $this->shouldThrow(\InvalidArgumentException::class)
             ->during('__construct', ['some_invalid_status']);
    }

    function it_gets_the_status_value()
    {
        $this->getValue()->shouldBe('publish');
        $this->shouldBePublished();
    }

    function it_can_be_constructed_as_future()
    {
        $this->beConstructedThrough('future');
        $this->getValue()->shouldBe('future');
        $this->shouldBeFuture();
    }

    function it_can_be_constructed_as_draft()
    {
        $this->beConstructedThrough('draft');
        $this->getValue()->shouldBe('draft');
        $this->shouldBeDraft();
    }

    function it_can_be_constructed_as_pending()
    {
        $this->beConstructedThrough('pending');
        $this->getValue()->shouldBe('pending');
        $this->shouldBePending();
    }

    function it_can_be_constructed_as_private()
    {
        $this->beConstructedThrough('private');
        $this->getValue()->shouldBe('private');
        $this->shouldBePrivate();
    }

    function it_can_be_constructed_with_trashed()
    {
        $this->beConstructedThrough('trashed');
        $this->getValue()->shouldBe('trash');
        $this->shouldBeTrashed();
    }
}
