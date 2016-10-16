<?php

namespace Spark\Extension\Command;

use Spark\Extension\Extension;
use Spark\Support\Command;

abstract class ScheduledEvent implements Extension, Command
{
    
    protected $hook;
    
    protected $auto_schedule = true;
    
    protected $singular = false;
    
    protected $recurrance;
    
    protected $args = [];

    public function getType() { return 'ScheduledEvent'; }
    
    public function register()
    {
        add_action( $this->getHook(), [$this, 'execute'] );
        if ( $this->auto_schedule )
            $this->schedule();
    }
        
    public function isRegistered()
    {
        return $this->isScheduled();
    }
    
    public function deregister()
    {
        return $this->unschedule();
    }
    
    public function schedule( $args = [] )
    {
        if ( $this->singular ) return $this->scheduleOnce( $args );
        $this->args = $args;
        $result = wp_schedule_event( $this->getStartingTimestamp(), $this->recurrance, $this->getHook(), $args );
        return false !== $result;
    }
    
    public function scheduleOnce( $args = [] )
    {
        $this->args = $args;
        $result = wp_schedule_single_event( $this->getStartingTimestamp(), $this->getHook(), $args );
        return false !== $result;
    }
    
    public function isScheduled()
    {
        return false !== $this->getNextScheduled();
    }
        
    public function unschedule()
    {
        wp_clear_scheduled_hook( $this->getHook() );
        return true;
    }
    
    public function getNextScheduled()
    {
        return wp_next_scheduled( $this->getHook(), $this->args );
    }
    
    protected function getHook()
    {
        if ( !isset( $this->hook ) ) {
            $this->hook = strtolower( str_replace( '\\', '_', get_class( $this ) ) );
        }
        return $this->hook;
    }
    
    protected function getStartingTimestamp()
    {
        return time();
    }
}
