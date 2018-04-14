<?php

namespace Spark\Extension\Theme;

use Spark\Support\Extension\Extension;
use Spark\Support\View;

/**
 * Extension wrapper for built-in widget class
 * 
 * @author cyruscollier
 *
 */
abstract class Widget extends \WP_Widget implements Extension, View
{
    protected $arguments;
    
    protected $instance;
    
    public function getType() { return 'Widget'; }
    
    public function register()
    {
        return add_action( 'widgets_init', [$this, 'init'] );
    }
    
    public function init()
    {
        register_widget( $this );
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
            return true;
        }
        return false;
    }
    
    public function widget( $arguments, $instance )
    {
        $this->prepare( compact( 'arguments', 'instance' ) );
        $this->render();
        $output = $this->cleanup();
        if (is_array($instance)) {
            echo $output;
        }
        return $output;
    }
    
    public function prepare( $arguments )
    {
        $this->arguments = $arguments['arguments'];
        $this->instance = $arguments['instance'];
        ob_start();
    }
    
    public function cleanup()
    {
        $output = ob_get_clean();
        $this->arguments = null;
        $this->instance = null;
        return $output;
    }
}