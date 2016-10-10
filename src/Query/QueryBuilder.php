<?php 

namespace Spark\Query;

use Spark\Model\Entity;
use Spark\Model\EntityCollection;

/**
 * Fluent interface for building query parameters
 * 
 * @author cyruscollier
 *
 */
interface QueryBuilder extends \IteratorAggregate
{
    
    /**
     * Constructor binds instance to a model class
     * 
     * @param string $model_class
     * @throws \InvalidArgumentException if argument is not the correct model class
     */
    public function __construct( $model_class );
    
    /**
     * Clears parameters and previous Colleciton, rebinds to a model class
     *
     * @param string $model_class
     * @return $this
     * @throws \InvalidArgumentException if argument is not the correct model class
     */
    public function reset( $model_class );
    
    /**
     * All records
     * 
     * @return $this
     */
    public function findAll();
    
    /**
     * Limit to one record
     * 
     * @return $this
     */
    public function findOne();
    
    /**
     * Filter records by provided parameters
     * 
     * @param array $params
     * @return $this
     */
    public function where( $params );
    
    /**
     * Set order and order by parameters (SQL style)
     * 
     * @param string $order_by
     * @return $this
     */
    public function orderBy( $order_by );
    
    /**
     * Limit number of found records
     * 
     * @param int $limit
     * @return $this
     */
    public function limit( $limit );
    
    /**
     * Specify page count
     * 
     * @param int $page
     * @return $this
     */
    public function page( $page );
    
    /**
     * Offset found records
     * 
     * @param int $offset
     * @return $this
     */
    public function offset( $offset );
    
    /**
     * Add structured subquery object
     * 
     * @param SubQuery $RelatedQuery
     * @return $this
     */
    public function withQuery( SubQuery $RelatedQuery );
    

    /**
     * Immediately return one matching record
     *
     * @param array $params
     * @return Entity|false
     */
    public function getOne( $params = [] );
    
    /**
     * Execute query and return colleciton of found records
     * 
     * @param mixed $id
     * @return EntityCollection
     */
    public function get( $id = false );
    
    /**
     * All sotred parameters
     * 
     * @return array
     */
    public function getParameters();
    
    /**
     * Execute query and return colleciton of found records
     * 
     * @return EntityCollection
     */
    public function getIterator();
    
}