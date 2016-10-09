<?php 

namespace Spark\Extension\Custom;

use Spark\Extension\Extension;

/**
 * Abstract Base class for registering custom post types and taxonomies
 * 
 * @author cyruscollier
 *
 */
abstract class Custom implements Extension {
	
	const NAME = null;
	
	protected $slug;
	protected $label_singular;
	protected $label_plural;
	protected $textdomain = 'spark';
	protected $format;
	
	protected $labels = [];
	protected $labels_defaults = [
		'name'                => '%3$s',
		'singular_name'       => '%2$s',
		'menu_name'           => '%3$s',
		'parent_item'		  => 'Parent %2$s',
		'parent_item_colon'   => 'Parent %2$s:',
		'all_items'           => 'All %3$s',
		'add_new_item'        => 'Add New %2$s',
		'view_item'           => 'View %2$s',
		'edit_item'           => 'Edit %2$s',
		'update_item'         => 'Update %2$s',
		'search_items'        => 'Search %4$s',
		'not_found'           => 'No %4$s found',
		'not_found_in_trash'  => 'No %4$s found in Trash'
	];
	
	protected $rewrite = [];
	protected $rewrite_defaults = [
		'slug'                => '%1$s',
		'with_front'          => true
	];
	
	protected $config = [];
	protected $config_defaults = [
		'hierarchical'        => true,
		'public'              => true,
		'has_archive'         => true
	];
	
	public function register()
	{
	    add_action( 'init', function() {
	        $config = $this->loadConfig();
	        $this->registerCustom( $config );
	    }, 1 );
	}
		
	public function isRegistered();
	
	public function deregister();
	
	abstract protected function registerCustom( $config );
	
	protected function formatMap( $value ) {
		if ( is_array( $value ) ) {
			$context = $value[1];
			$value = $value[0];
		}
		$value = sprintf( $value,
			static::NAME,
			$this->label_singular,
			$this->label_plural,
			strtolower( $this->label_plural )
		);
		if ( $context ) {
			return _x( $value, $context, $this->textdomain );
		}
		if ( is_string( $value ) ) {
			return __( $value, $this->textdomain );
		}
		return $value;
	}
		
	protected function loadConfig() {
		$labels = wp_parse_args( $this->labels, $this->labels_defaults );
		$labels = array_map( [$this, 'formatMap'], $labels );
		$rewrite = wp_parse_args( $this->rewrite, $this->rewrite_defaults );
		$rewrite['slug'] = sprintf( $rewrite['slug'], $this->slug );
		$config = wp_parse_args( $this->config, $this->config_defaults );
		$config['labels'] = $labels;
		$config['rewrite'] = $rewrite;
		return $config;
	}
}
