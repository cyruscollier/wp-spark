<?php 

namespace Spark\Query\QueryBuilder;

use Spark\Model\Model;
use Spark\Model\PostType;
use Spark\Model\Collection;
use Spark\Query\SubQuery;

class PostTypeQueryBuilder implements QueryBuilder {
    
    /**
     * Bound model class name
     * 
     * @var string
     */
    protected $model_class;
    
    /**
     * List of parameters for get_posts()
     * 
     * @var array
     */
    protected $parameters = [];
    
    /**
     * Stored after each query
     * 
     * @var Collection
     */
    protected $cached_collection;
    
    /**
     * Constructor checks if provided model class name is a PostType
     * 
     * @param string $model_class
     * @throws \InvalidArgumentException
     */
    public function __construct( $model_class )
    {
        if ( !is_a( $model_class, PostType::class, true ) )
            throw new \InvalidArgumentException( 'Provided class name is not a Model: ' . $model_class );
        $this->model_class = $model_class;
        $this->parameters['post_type'] = $model_class::POST_TYPE;
    }
    
    /**
     * All records
     * 
     * @return $this
     */
    public function findAll()
    {
        $this->cached_collection = null;
        $this->parameters['posts_per_page'] = -1;
        return $this;
    }
    
    /**
     * Immediately return one matching record
     * 
     * @param array $params
     * @return Model|false
     */
    public function findOne( $params = [] )
    {
        $this->cached_collection = null;
        $Collection = $this->where( $params )->get();
        return !empty( $Collection ) ? $Collection[0] : false;
    }
    
    /**
     * Filter records by provided parameters
     * 
     * @param array $params
     * @return $this
     */
    public function where( $params )
    {
        $this->cached_collection = null;
        $this->parameters = array_merge( $this->parameters, $this->sanitizeParams( $params ) );
        return $this;
    }
    
    /**
     * Set order and order by parameters (SQL style)
     * 
     * @param string|array $order_by
     * @return $this
     */
    public function orderBy( $order_bys )
    {
        $this->cached_collection = null;
        if ( !isset( $this->parameters['orderby'] ) ) $this->parameters['orderby'] = [];
        if ( !isset( $this->parameters['order'] ) ) $this->parameters['order'] = [];
        if ( !is_array( $order_bys ) ) $order_bys = explode( ',', $order_bys );
        foreach ( $order_bys as $order_by ) {
            $parts = explode( ' ', $order_by );
            $this->parameters['orderby'][] = $parts[0];
            $this->parameters['order'][] = isset( $parts[1] ) ? $parts[1] : 'DESC';
        }
        return $this;
    }
    
    /**
     * Limit number of found records
     * 
     * @param int $limit
     * @return $this
     */
    public function limit( $limit )
    {
        $this->cached_collection = null;
        $this->parameters['posts_per_page'] = (int) $limit;
        return $this;
    }
    
    /**
     * Specify page count
     * 
     * @param int $page
     * @return $this
     */
    public function page( $page )
    {
        $this->cached_collection = null;
        $this->parameters['paged'] = (int) $page;
        return $this;
    }
    
    /**
     * Offset found records
     * 
     * @param int $offset
     * @return $this
     */
    public function offset( $offset )
    {
        $this->cached_collection = null;
        $this->parameters['offset'] = (int) $offset;
    }
    
    /**
     * Add structured subquery object
     * 
     * @param SubQuery $SubQuery
     * @return $this
     */
    public function withQuery( SubQuery $SubQuery )
    {
        $this->cached_collection = null;
        $key = $SubQuery->getQueryKey();
        $this->parameters[$key] = $SubQuery->build();
        return $this;
    }
    
    /**
     * Execute query and return colleciton of found records
     * 
     * @return Collection
     */
    public function get()
    {
        $posts = get_posts( $this->parameters );
        $items = [];
        $post_type = $this->model_class;
        foreach ( $posts as $post ) {
            $items[] = $post_type::createFromPost( $post );
        }
        $this->cached_collection = new Collection( $items );
        return $this->cached_collection;
    }
    
    /**
     * Execute query and return collection of found records
     * 
     * @return Collection
     */
    public function getIterator()
    {
        return $this->cached_collection ? 
            $this->cached_collection->getIterator() :
            $this->get()->getIterator();
    } 
    
    /**
     * Remove or alter input parameters
     * 
     * @param array $params
     * @return array
     */
    protected function sanitizeParams( $params ) {
        if ( isset( $params['post_type'] ) ) unset( $params['post_type'] );
        return $params;
    }
        
}