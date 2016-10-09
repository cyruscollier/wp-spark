<?php 

namespace Spark\Extension\Custom;

/**
 * Register a custom Post Type
 * 
 * Format guide:
 * %1$s => $this->name,
 * %2$s => $this->label_singular,
 * %3$s => $this->label_plural,
 * %4$s => strtolower($this->label_plural)
 * 
 * @author cyruscollier
 *
 */
abstract class CustomPostType extends Custom {
	
	protected $labels = [
		'name'                => ['%3$s', 'Post Type General Name'],
		'singular_name'       => ['%2$s', 'Post Type Singular Name'],
		'new_item'            => 'New %2$s',
		'not_found'           => 'No %4$s found',
		'not_found_in_trash'  => 'No %4$s found in Trash'
	];
	
	protected $rewrite = ['pages' => true];
	
	protected $config = [
		'description'         => '%2$s pages',
		'supports'            => ['title', 'editor', 'thumbnail'],
		'show_in_menu'        => true,
		'menu_position'       => 5
	];
	
	protected function registerCustom( $config )
	{
		register_post_type( static::NAME, $config );
	}	
	
	public function getType() { return 'CustomPostType'; }
	
	
	public function isRegistered()
	{
	    return post_type_exists( static::NAME );
	}
	
	public function deregister()
	{
	    global $wp_post_types;
	    if ( isset( $wp_post_types[static::NAME] ) ) {
	       unset( $wp_post_types[static::NAME] );
	    }
	}
}
