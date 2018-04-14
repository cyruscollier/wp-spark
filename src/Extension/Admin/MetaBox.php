<?php

namespace Spark\Extension\Admin;

use Spark\Support\View;
use Spark\Support\Extension\Extension;

abstract class MetaBox implements Extension, View
{
    protected $post_type;
    
    protected $id;
    
    protected $title;
    
    protected $screen;
    
    protected $context = 'advanced';
    
    protected $priority = 'default';

    protected $post;
    
    public function getType() { return 'Metabox'; }
    
    public function register()
    {
        $action = 'add_meta_boxes';
        if ( isset( $this->post_type ) ) $action .= "_{$this->post_type}";
        return add_action( $action, [$this, 'init'] );
    }
    
    public function init( $arg = null ) {
        if ( is_string( $arg ) && post_type_exists( $arg ) ) {
            $this->post_type = $arg;
        }
        $this->screen = $this->getScreen( $this->screen );
        add_meta_box( 
            $this->id, 
            $this->title, 
            [$this, 'renderMetabox'], 
            $this->screen,
            $this->context,
            $this->priority
        );
        return true;
    }
    
    public function isRegistered()
    {
        global $wp_meta_boxes;
    	$screens = is_array( $this->screen ) ? $this->screen : [$this->screen];
    	foreach ( $screens as $screen) {
    	    if ( is_object( $screen ) ) $screen = $screen->id;
    	    if ( !empty( $wp_meta_boxes[$screen][$this->context][$this->priority][$this->id] ) )
	            return true;
    	}
    	return false;
    }
    
    public function deregister()
    {
        remove_meta_box( $this->id, $this->screen, $this->context );
        return true;
    }
    
    public function renderMetabox( $post, $echo = false )
    {
        $this->prepare( $post );
        $this->render();
        $output = $this->cleanup();
        if ($echo !== false) {
            echo $output;
        }
        return $output;
    }
    
    public function prepare( $post ) {
        $this->post = $post;
        ob_start();
    }
    
    public function cleanup() {
        return ob_get_clean();
    }
        
    protected function getScreen( $screen = null )
    {
        if ( is_array( $screen ) ) {
            return array_map( [$this, 'getScreen'], $screen );
        }
        return $screen ? convert_to_screen( $screen ) : get_current_screen();
    }

}