<?php

namespace Spark\Extension\Theme;

abstract class Shortcode implements Extension
{
    const TAG = null;
    
    protected $arguments_defaults = [];
    
    protected $arguments;
    
    protected $content;
    
    public function getType() { return 'Shortcode'; }
    
    public function register()
    {
        add_shortcode( static::TAG, [$this, 'render'] );
    }
    
    public function isRegistered()
    {
        shortcode_exists( static::TAG );
    }
    
    public function deregister()
    {
        remove_shortcode( static::TAG );
    }
    
    public function render( $args, $content = '' )
    {
        $this->arguments = shortcode_atts( $this->arguments_defaults, $atts );
        $this->content = $content;
        ob_start();
        $this->shortcodeView();
        $content = ob_get_clean();
        $return_content = !empty( $content ) ? $content : $this->content;
        $this->arguments = null;
        $this->content = null;
        return $return_content;
    }
    
    abstract protected function shortcodeView();
}