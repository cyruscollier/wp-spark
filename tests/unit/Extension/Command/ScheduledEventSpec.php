<?php

namespace unit\Spark\Extension\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Extension\Command\ScheduledEvent;

class ScheduledEventSpec extends ObjectBehavior
{
    const HOOK = 'unit_scheduled_event_test';
    
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Extension\Command\ScheduledEvent');
    }
    
    function let()
    {
        $this->beAnInstanceOf(ScheduledEventTest::class);
    }
    
    function it_registers_the_event_hook($functions)
    {
        $functions->add_action(self::HOOK, Argument::type('callable'))->shouldBeCalled();
        $this->register()->shouldReturn(true);
    }
    
    function it_checks_if_event_is_registered_true($functions)
    {
        $functions->has_action(self::HOOK, Argument::type('callable'))->willReturn(true);
        $this->isRegistered()->shouldReturn(true);
    }
    
    function it_checks_if_event_is_registered_false($functions)
    {
        $functions->has_action(self::HOOK, Argument::type('callable'))->willReturn(false);
        $this->isRegistered()->shouldReturn(false);
    }
    
    function it_deregisters_the_event($functions)
    {
        $functions->remove_action(self::HOOK, Argument::type('callable'))->shouldBeCalled();
        $functions->wp_clear_scheduled_hook(self::HOOK)->willReturn(true);
        $this->deregister()->shouldReturn(true);
    }
    
    function it_schedules_the_event($functions)
    {
        $functions->time()->willReturn(12345);
        $functions->wp_schedule_event(12345, 'daily', self::HOOK, [] )->willReturn(null);
        $this->schedule()->shouldReturn(true);
    }
    
    function it_schedules_the_event_once($functions)
    {
        $functions->time()->willReturn(12345);
        $functions->wp_schedule_single_event(12345, self::HOOK, [] )->willReturn(null);
        $this->scheduleOnce()->shouldReturn(true);
    }
    
    function it_checks_if_event_is_scheduled_true($functions)
    {
        $functions->wp_next_scheduled( self::HOOK, [] )->willReturn(123456);
        $this->isScheduled()->shouldReturn(true);
    }
    
    function it_checks_if_event_is_scheduled_false($functions)
    {
        $functions->wp_next_scheduled( self::HOOK, [] )->willReturn(false);
        $this->isScheduled()->shouldReturn(false);
    }
    
    function it_unschedules_the_event($functions)
    {
        $functions->wp_clear_scheduled_hook(self::HOOK)->willReturn(true);
        $this->unschedule()->shouldReturn(true);
    }
    
}

class ScheduledEventTest extends ScheduledEvent
{
    protected $auto_schedule = false;
    
    public function execute()
    {
        return 'test executed';
    }
}