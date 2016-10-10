<?php

namespace Spark\Extension\Theme;

use Spark\Extension\Extension;

/**
 * Extension wrapper for built-in widget class
 * 
 * @author cyruscollier
 *
 */
abstract class Widget extends \WP_Widget implements Extension
{
    protected $arguments;
    
    protected $instance;
    
    public function getType() { return 'Widget'; }
    
    public function register()
    {
        add_action( 'widgets_init', function() {
            register_widget( $this );
        } );
    }
    
    public function isRegistered()
    {
        global $wp_widget_factory; /* @var \WP_Widget_Factory $wp_widget_factory */
        return in_array( $this, $wp_widget_factory->widgets );
    }
    
    public function deregister()
    {
        if ( $this->isRegistered() ) {
            unregister_widget( $this );
        }
    }
    
    public function widget( $args, $instance )
    {
        $this->arguments = $args;
        $this->instance = $instance;
        $this->renderView();
        $this->arguments = null;
        $this->instance = null;
    }
    
    abstract protected function renderView();
}