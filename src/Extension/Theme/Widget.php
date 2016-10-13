<?php

namespace Spark\Extension\Theme;

use Spark\Extension\Extension;
use Spark\Support\View;
use WP_Widget;

/**
 * Extension wrapper for built-in widget class
 * 
 * @author cyruscollier
 *
 */
abstract class Widget extends WP_Widget implements Extension, View
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
    
    public function widget( $arguments, $instance )
    {
        $this->prepare( compact( 'arguments', 'instance' ) );
        $this->render();
        $this->cleanup();
    }
    
    public function prepare( $_arguments )
    {
        extract( $_arguments );
        $this->arguments = $arguments;
        $this->instance = $instance;
    }
    
    public function cleanup()
    {
        $this->arguments = null;
        $this->instance = null;
    }
}