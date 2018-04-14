<?php

namespace Spark\Support\Query;

/**
 * Base class for building query parameter sets for WP_Query::set()
 * Child classes built based on current WP_Query API
 * 
 * @author cyruscollier
 *
 */
interface SubQuery
{
    /**
     * QueryBuilder constructor.
     * @param string $relation
     */
    function __construct($relation = 'AND');

    /**
     * @param string $relation
     *
     * @return $this
     */
    function setRelation($relation = 'AND');

    /**
     * Assembles clauses and prepares it for query assignment
     *
     * @param bool $filtered
     *
     * @return array
     */
    public function build($filtered = true): array;
    
    /**
     * Adds clause
     * 
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    function add( $key, $value );
    
    /**
     * Name of query key to user for this subquery
     * 
     * @return string
     */
    function getQueryKey();

    /**
     * @param SubQuery $Subquery
     *
     * @return $this
     */
    function addSubQuery(SubQuery $Subquery);

    
    
}