<?php 

namespace Spark\Extension\Entity;

/**
 * Register a custom Post Type
 * 
 * @author cyruscollier
 *
 */
abstract class PostType extends Entity {
	
	protected $labels_defaults = [
        'add_new'             => 'Add New',
		'new_item'            => 'New @S',
		'not_found_in_trash'  => 'No @p found in Trash'
	];
	
	protected $contexts = [
        'name'                => 'post type general name',
        'singular_name'       => 'post type singular name',
        'add_new'             => '@n',
	];
		
	protected $config_defaults = [
        'public'              => true,
        'has_archive'         => true,
		'supports'            => ['title', 'editor', 'thumbnail'],
		'show_in_menu'        => true,
		'menu_position'       => 5
	];
	
	protected function registerEntity( $config )
	{
		return register_post_type( static::NAME, $config );
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
	       return true;
	    }
	    return false;
	}
}
