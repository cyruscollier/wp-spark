<?php 

namespace Spark\Extension\Custom;

/**
 * Register a custom Taxonomy
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
abstract class CustomTaxonomy extends Custom {
	
	protected $post_types = [];
	
	protected $labels = [
		'name'                => ['%3$s', 'Taxonomy General Name'],
		'singular_name'       => ['%2$s', 'Taxonomy Singular Name'],
		'new_item_name'       => 'New %2$s Name',
		'separate_items_with_commas' => 'Separate %4$s with commas',
		'add_or_remove_items' => 'Add or remove %4$s',
		'choose_from_most_used' => 'Choose from the most used %4$s',
		'popular_items' => 'Popular %4$s'
	];
	
	protected $rewrite = ['hierarchical' => true];
	
	protected function registerCustom( $config ) {
		register_taxonomy( static::NAME, $this->post_types, $config );
	}
	
	public function getType() { return 'CustomTaxonomy'; }
	
	
	public function isRegistered()
	{
	    return taxonomy_exists( static::NAME );
	}
	
	public function deregister()
	{
	    global $wp_taxonomies;
	    if ( isset( $wp_taxonomies[self::NAME] ) ) {
	        unset( $wp_taxonomies[self::NAME] );
	    }
	}
}
