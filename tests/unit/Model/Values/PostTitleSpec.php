<?php

namespace unit\Spark\Model\Values;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostTitleSpec extends ObjectBehavior
{
    const TITLE = 'Some Post Title';
    
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Model\Values\PostTitle');
    }
    
    function let()
    {
        $this->beConstructedWith(self::TITLE);
    }
    
    function it_gets_the_raw_value()
    {
        $this->raw()->shouldReturn(self::TITLE);
    }
    
    function it_gets_the_filtered_value($functions)
    {
        $functions->apply_filters('the_title', self::TITLE)->willReturn('<b>'.self::TITLE.'</b>');
        $this->filtered()->shouldReturn('<b>'.self::TITLE.'</b>');
        $this->getValue()->shouldReturn('<b>'.self::TITLE.'</b>');
        $this->__toString()->shouldReturn('<b>'.self::TITLE.'</b>');
    }
}
