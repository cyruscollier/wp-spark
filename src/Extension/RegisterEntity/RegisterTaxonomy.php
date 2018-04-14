<?php 

namespace Spark\Extension\RegisterEntity;

/**
 * Register a custom Taxonomy
 *
 * @author cyruscollier
 *
 */
abstract class RegisterTaxonomy extends RegisterEntity {
	
	protected $post_types = [];
	
	protected $labels_defaults = [
		'new_item_name'              => 'New @S Name',
		'separate_items_with_commas' => 'Separate @p with commas',
		'add_or_remove_items'        => 'Add or remove @p',
		'choose_from_most_used'      => 'Choose from the most used @p',
		'popular_items'              => 'Popular @p'
	];
	
	protected $contexts = [
		'name'                => 'taxonomy general name',
		'singular_name'       => 'taxonomy singular name',    
	];
		
	protected function registerEntity( $config ) {
	    global $wp_taxonomies;
		register_taxonomy( static::NAME, $this->post_types, $config );
		register_taxonomy_for_object_type( static::NAME, $this->post_types );
		return get_taxonomy(static::NAME);
	}
	
	public function getType() { return 'CustomTaxonomy'; }
	
	public function isRegistered()
	{
	    return taxonomy_exists( static::NAME );
	}
	
	public function deregister()
	{
	    global $wp_taxonomies;
	    if ( isset( $wp_taxonomies[static::NAME] ) ) {
	        unset( $wp_taxonomies[static::NAME] );
	        return true;
	    }
	    return false;
	}
}
