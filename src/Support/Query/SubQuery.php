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
     * Assembles clauses and prepares it for query assignment
     * 
     * @return array
     */
    public function build(): array;
    
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

    
    
}