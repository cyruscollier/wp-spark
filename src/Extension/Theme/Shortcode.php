<?php

namespace Spark\Extension\Theme;

use Spark\Support\View;
use Spark\Extension\Extension;

abstract class Shortcode implements Extension, View
{
    const TAG = null;
    
    protected $arguments_defaults = [];
    
    protected $arguments;
    
    protected $content;
    
    public function getType() { return 'Shortcode'; }
    
    public function register()
    {
        add_shortcode( static::TAG, [$this, 'renderShortcode'] );
        return true;
    }
    
    public function isRegistered()
    {
        return shortcode_exists( static::TAG );
    }
    
    public function deregister()
    {
        if ( $this->isRegistered() ) {
            remove_shortcode( static::TAG );
            return true;
        }
        return false;
    }
    
    public function renderShortcode( $arguments, $content = '' )
    {
        $this->prepare( compact( 'arguments', 'content' ) );
        $this->render();
        return $this->cleanup();
    }
    
    public function prepare( $arguments ) {
        $this->arguments = shortcode_atts( $this->arguments_defaults, $arguments['arguments'] );
        $this->content = $content;
        ob_start();
    }
    
    public function cleanup() {
        $content = ob_get_clean();
        $return_content = !empty( $content ) ? $content : $this->content;
        $this->arguments = null;
        $this->content = null;
        return $return_content;
    }

}