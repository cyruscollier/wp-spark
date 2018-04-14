<?php 

namespace Spark\Support\Query;

/**
 * Fluent interface for building query parameters
 * 
 * @author cyruscollier
 *
 */
interface QueryBuilder
{
    /**
     * Clears parameters
     *
     * @return $this
     */
    function reset();
    
    /**
     * All records
     * 
     * @return $this
     */
    function all();
    
    /**
     * Limit to one record
     * 
     * @return $this
     */
    function one();
    
    /**
     * Filter records by provided parameters
     * 
     * @param array $params
     *
     * @return $this
     */
    function where($params);
    
    /**
     * Set order and order by parameters (SQL style)
     * 
     * @param string|array $order_bys
     *
     * @return $this
     */
    function orderBy($order_bys);
    
    /**
     * Limit number of found records
     * 
     * @param int $limit
     *
     * @return $this
     */
    function limit($limit);
    
    /**
     * Offset found records
     * 
     * @param int $offset
     *
     * @return $this
     */
    function offset($offset);
    
    /**
     * Add structured subquery object
     * 
     * @param SubQuery $RelatedQuery
     * @return $this
     */
    function withSubQuery(SubQuery $RelatedQuery);
    
    /**
     * All constructed parameters
     * 
     * @return array
     */
    function build(): array;
}