<?php

namespace Spark\Query;

/**
 * Base class for building query parameter sets for WP_Query::set()
 * Child classes built based on current WP_Query API
 * 
 * @author cyruscollier
 *
 */
abstract class SubQuery
{

    /**
     * Holds stack of query clauses
     * @var array
     */
    private $query = [];
    
    /**
     * Assembles clauses and prepares it for query assignment
     * 
     * @param string $relation
     * @return array
     */
    public function build( $relation = 'AND' )
    {
        $filtered_query = array_filter( $this->query, [$this, 'hasClauseValue'] );
        if ( count( $filtered_query ) > 1 ) $filtered_query['relation'] = $relation;
        return $filtered_query;
    }
    
    /**
     * Adds clause to stack, used with public fluent wrapper methods
     * 
     * @param array $clause
     * @return $this
     */
    protected function addClause( array $clause )
    {
        $this->query[] = $clause;
        return $this;
    }
    
    /**
     * Checks if clause has empty value
     * 
     * @param array $clause
     * @return bool
     */
    protected function hasClauseValue( array $clause )
    {
        $value = $this->getClauseValue( $clause );
        if ( is_array( $value ) ) $value = array_filter( $value, function($v) { return isset($v); } );
        return isset( $value );
    }
    
    /**
     * Adds clause
     * 
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    abstract function add( $key, $value );
    
    /**
     * Name of query key to user for this subquery
     * 
     * @return string
     */
    abstract function getQueryKey();
    
    /**
     * Gets value inside of clause
     * 
     * @param array $clause
     * @return mixed
     */
    abstract protected function getClauseValue( array $clause );
    
    
}