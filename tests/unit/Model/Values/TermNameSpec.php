<?php

namespace unit\Spark\Model\Values;

use Spark\Model\Values\TermName;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TermNameSpec extends ObjectBehavior
{
    const NAME = 'some term name';

    function it_is_initializable()
    {
        $this->shouldHaveType(TermName::class);
    }

    function let()
    {
        $this->beConstructedWith(self::NAME);
    }

    function it_gets_the_value_as_a_single_title($functions)
    {
        $functions->apply_filters('single_term_title', self::NAME)->willReturn('<b>'.self::NAME.'</b>');
        $this->asSingleTitle()->shouldReturn('<b>'.self::NAME.'</b>');
    }
}
