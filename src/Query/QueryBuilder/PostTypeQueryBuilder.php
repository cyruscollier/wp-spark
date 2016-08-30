<?php 

namespace Spark\Query\QueryBuilder;

use Spark\Model\Model;
use Spark\Model\PostType;
use Spark\Model\ModelCollection;
use Spark\Query\SubQuery;
use Spark\Query\QueryBuilder;

/**
 * Query Builder for all post types
 * 
 * @author ccollier
 *
 */
class PostTypeQueryBuilder extends QueryBuilderWithMetadata
{
    /**
     * Parent model class of bounded class
     *
     * @var string
     */
    protected $base_model_class = PostType::class;
    
    /**
     * Clears parameters and previous Colleciton, rebinds to a model class
     *
     * @param string $model_class
     */
    public function reset( $model_class ) {
        parent::reset( $model_class );
        $this->parameters['post_type'] = $model_class::POST_TYPE;
        return $this;
    }
    
    /**
     * All records
     * 
     * @return $this
     */
    public function findAll()
    {
        $this->previousCollection = null;
        $this->parameters['posts_per_page'] = -1;
        return $this;
    }
    
    /**
     * Immediately return one matching record
     * 
     * @return $this
     */
    public function findOne()
    {
        return $this->limit( 1 );
    }
    
    /**
     * Filter records by provided parameters
     * 
     * @param array $params
     * @return $this
     */
    public function where( $params )
    {
        $this->previousCollection = null;
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
        $this->previousCollection = null;
        if ( !isset( $this->parameters['orderby'] ) ) $this->parameters['orderby'] = [];
        if ( !isset( $this->parameters['order'] ) ) $this->parameters['order'] = [];
        if ( !is_array( $order_bys ) ) $order_bys = explode( ',', $order_bys );
        foreach ( $order_bys as $order_by ) {
            $parts = explode( ' ', trim( $order_by ) );
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
        $this->previousCollection = null;
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
        $this->previousCollection = null;
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
        $this->previousCollection = null;
        $this->parameters['offset'] = (int) $offset;
        return $this;
    }
    
    /**
     * Add structured subquery object
     * 
     * @param SubQuery $SubQuery
     * @return $this
     */
    public function withQuery( SubQuery $SubQuery )
    {
        $this->previousCollection = null;
        $key = $SubQuery->getQueryKey();
        $this->parameters[$key] = $SubQuery->build();
        return $this;
    }
    
    /**
     * Immediately return one matching record
     * 
     * @param array $params
     * @return Model|false
     */
    public function getOne( $params = [] )
    {
        $this->previousCollection = null;
        $Collection = $this->where( $params )->findOne()->get();
        return !empty( $Collection ) ? $Collection[0] : false;
        
    }
    
    /**
     * Get single post if id provided or collection using stored parameters
     * 
     * @return ModelCollection
     */
    public function get( $id = false )
    {
        if ( false !== $id ) {
            return $this->getPost( $id );
        }
        return $this->getPosts();
    }
    
    /**
     * All sotred parameters
     * 
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
    
    /**
     * Execute query and return collection of found records
     * 
     * @return ModelCollection
     */
    public function getIterator()
    {
        return $this->previousCollection ? 
            $this->previousCollection->getIterator() :
            $this->get()->getIterator();
    } 
    
    /**
     * Remove or alter input parameters
     * 
     * @param array $params
     * @return array
     */
    protected function sanitizeParams( $params )
    {
        if ( isset( $params['post_type'] ) ) unset( $params['post_type'] );
        return $params;
    }
    
    protected function getPost( $id )
    {
        $post_type = $this->model_class;
        $all_metadata = $this->getAllMetadata( [$id] );
        return $post_type::createFromPost( get_post( $id ), $all_metadata[$id] );
    }
    
    protected function getPosts()
    {
        $this->previousCollection = new ModelCollection();
        $post_type = $this->model_class;
        $posts = get_posts( $this->parameters );
        $post_ids = array_map( function( $p ) { return $p->ID; }, $posts );
        $all_metadata = $this->getAllMetadata( $post_ids );
        foreach ( $posts as $post ) {
            $Post = $post_type::createFromPost( $post, $all_metadata[$post->ID] );
            $this->previousCollection->add( $Post );
        }
        return $this->previousCollection;
    }
        
}