<?php 

namespace Spark\Extension\Entity;

use Spark\Extension\Extension;

/**
 * Abstract Base class for registering custom post types and taxonomies
 * 
 * @author cyruscollier
 *
 */
abstract class Entity implements Extension {
	
	const NAME = null;
	const FORMAT_NAME = '@n';
	const FORMAT_SLUG = '@s';
	const FORMAT_SINGULAR = '@S';
	const FORMAT_PLURAL = '@P';
	const FORMAT_PLURAL_LOWERCASE = '@p';
	
	
	protected $slug;
	protected $label_singular;
	protected $label_plural;
	protected $text_domain = SPARK_TEXT_DOMAIN;
	
	protected $labels = [];
	protected $labels_defaults = [];
	protected $labels_defaults_shared = [
		'name'                => '@P',
		'singular_name'       => '@S',
		'menu_name'           => '@P',
		'parent_item'		  => 'Parent @S',
		'parent_item_colon'   => 'Parent @P:',
		'all_items'           => 'All @P',
		'add_new_item'        => 'Add New @S',
		'view_item'           => 'View @S',
		'edit_item'           => 'Edit @S',
		'update_item'         => 'Update @S',
		'search_items'        => 'Search @P',
		'not_found'           => 'No @p found',
	];
	
	protected $contexts = [];
	
	protected $rewrite = [];
	protected $rewrite_defaults = [];
	
	protected $config = [];
	protected $config_defaults = [];
	
	public function register()
	{
	    return add_action( 'init', function() {
	        $this->registerCustom( $this->getConfig() );
	    }, 1 );
	}
	
	public function getLabels()
	{
	    $labels = array_merge( $this->labels_defaults_shared, $this->labels_defaults, $this->labels );
	    array_walk( $labels, [$this, 'formatLabel'] );
	    return $labels;
	}
	
	public function getRewrite()
	{
	    $rewrite = array_merge( $this->rewrite_defaults, $this->rewrite );
	    if ( isset( $this->slug ) ) {
	        $rewrite['slug'] = $this->slug;
	    }
	    return $rewrite;
	}
	
	public function getConfig()
	{		
		$config = array_merge( $this->config_defaults, $this->config );
		$config['labels'] = $this->getLabels();
		$config['rewrite'] = $this->getRewrite();
		return $config;
	}
	
	abstract protected function registerCustom( $config );
	
	protected function formatLabel( &$value, $key )
	{
	    $formatted_value = str_replace(
		    [self::FORMAT_SINGULAR, self::FORMAT_PLURAL, self::FORMAT_PLURAL_LOWERCASE],
		    [$this->label_singular, $this->label_plural, strtolower( $this->label_plural )],
		    $value
		);
	    $func = '__';
	    $args = [$formatted_value];
		if ( isset( $this->contexts[$key] ) ) {
			$args[] = str_replace( self::FORMAT_NAME, static::NAME, $this->contexts[$key] );
			$func = '_x';
		}
		$value = function_exists( $func ) ? call_user_func_array( $func, $args ) : $formatted_value;
	}
}
