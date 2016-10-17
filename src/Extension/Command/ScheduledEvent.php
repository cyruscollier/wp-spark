<?php

namespace Spark\Extension\Command;

use Spark\Extension\Extension;
use Spark\Support\Command;

abstract class ScheduledEvent implements Extension, Command
{
    
    protected $hook;
    
    protected $auto_schedule = true;
    
    protected $singular = false;
    
    protected $recurrance = 'daily';
    
    protected $args = [];

    public function getType() { return 'ScheduledEvent'; }
    
    public function register()
    {
        add_action( $this->getHook(), [$this, 'execute'] );
        return $this->auto_schedule ? $this->schedule() : true;
    }
        
    public function isRegistered()
    {
        return has_action( $this->getHook(), [$this, 'execute'] );
    }
    
    public function deregister()
    {
        remove_action( $this->getHook(), [$this, 'execute'] );
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
    
    protected function getNextScheduled()
    {
        return wp_next_scheduled( $this->getHook(), $this->args );
    }
    
    protected function getHook()
    {
        if ( !isset( $this->hook ) ) {
            $class_pieces = explode( '\\', get_class( $this ) );
            $hook = end( $class_pieces );
            if ( count( $class_pieces ) > 1 ) $hook = reset( $class_pieces ) . $hook;
            $this->hook = spark_to_snake_case( $hook );
        }
        return $this->hook;
    }
    
    protected function getStartingTimestamp()
    {
        return time();
    }
}
