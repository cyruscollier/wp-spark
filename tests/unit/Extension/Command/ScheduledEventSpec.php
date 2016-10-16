<?php

namespace unit\Spark\Extension\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Extension\Command\ScheduledEvent;

class ScheduledEventSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Extension\Command\ScheduledEvent');
    }
    
    function let()
    {
        $this->beAnInstanceOf(ScheduledEventTest::class);
    }
}

class ScheduledEventTest extends ScheduledEvent
{
    public function execute()
    {
        return 'test executed';
    }
}