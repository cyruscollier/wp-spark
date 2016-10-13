<?php

namespace Spark\Extension\Admin;

use Spark\Support\View;
use Spark\Extension\Extension;

abstract class MetaBox implements Extension, View
{
    protected $post_type;
    
    protected $id;
    
    protected $title;
    
    protected $screen;
    
    protected $context = 'advanced';
    
    protected $priority = 'default';
    
    public function getType() { return 'Metabox'; }
    
    public function register()
    {
        $callback = function( $arg ) {
            if ( is_string( $arg ) && post_type_exists( $arg ) ) {
                $this->post_type = $arg;
            }
            add_meta_box( 
                $this->id, 
                $this->title, 
                [$this, 'renderMetabox'], 
                $this->screen,
                $this->context,
                $this->priority
            );
        };
        if ( isset( $this->post_type ) ) {
            add_action( 'add_meta_boxes_' . $this->post_type, $callback );
        } else {
            add_action( 'add_meta_boxes', $callback );
        }
    }
    
    public function isRegistered()
    {
        global $wp_meta_boxes;

    	if ( empty( $screen ) ) {
    		$screen = get_current_screen();
    	} elseif ( is_string( $screen ) ) {
    		$screen = convert_to_screen( $screen );
    	} elseif ( is_array( $screen ) ) {
    		foreach ( $screen as $single_screen ) {
    			remove_meta_box( $id, $single_screen, $context );
    		}
    	}

    	if ( ! isset( $screen->id ) ) {
    		return;
    	}
    
    	$page = $screen->id;
    
    	if ( !isset($wp_meta_boxes) )
    		$wp_meta_boxes = array();
    	if ( !isset($wp_meta_boxes[$page]) )
    		$wp_meta_boxes[$page] = array();
    	if ( !isset($wp_meta_boxes[$page][$context]) )
    		$wp_meta_boxes[$page][$context] = array();
    
    	foreach ( array('high', 'core', 'default', 'low') as $priority )
    		$wp_meta_boxes[$page][$context][$priority][$id] = false;
    }
    
    public function deregister()
    {
        remove_meta_box( $this->id, $this->screen, $this->context );
    }
    
    public function renderMetabox( $post )
    {
        $this->prepare( $post );
        $this->render();
        $this->cleanup();
    }
    
    public function prepare( $post ) {
        $this->post = $post;
    }
    
    public function cleanup() {}

}