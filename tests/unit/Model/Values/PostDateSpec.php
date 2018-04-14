<?php

namespace unit\Spark\Model\Values;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostDateSpec extends ObjectBehavior
{
    const DATE = '2016-08-30 12:00:00';

    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Model\Values\PostDate');
    }
    
    function let()
    {
        $this->beConstructedWith(self::DATE);
    }
    
    function it_formats_the_date_with_stored_default($functions)
    {
        $functions->get_option('date_format')->willReturn('F j, Y g:ia');
        $this->defaultFormat()->shouldReturn('August 30, 2016 12:00pm');
        $this->__toString()->shouldReturn('August 30, 2016 12:00pm');
    }
        
    function it_formats_the_date_with_filter($functions)
    {
        $functions->apply_filters('get_the_date', '2016-08-30 12:00:00', 'Y-m-d H:i:s')
             ->willReturn('2016-08-30 12:00:00');
        $this->format('Y-m-d H:i:s')->shouldReturn('2016-08-30 12:00:00');
    }
}
