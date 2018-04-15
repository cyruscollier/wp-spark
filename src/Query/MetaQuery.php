<?php

namespace Spark\Query;

/**
 * Builds query clauses for 'meta_query' variable of WP_Query
 * 
 * @author cyruscollier
 *
 */
class MetaQuery extends SubQuery
{
    protected $query_key = 'meta_query';
    protected $clause_value_key = 'value';

    /**
     * Adds clause
     *
     * @param string $key
     * @param mixed $value
     * @param string $compare
     * @param string $type
     * @return $this
     */
    public function add( $key, $value, $compare = '=', $type = 'CHAR' )
    {
        return $this->addClause( compact( 'key', 'value', 'compare', 'type' ) );
    }
    
    /**
     * Public fluent wrapper for adding range clause
     *
     * @param string $key
     * @param int $lower_value
     * @param int $upper_value
     * @return $this
     */
    public function addRange( $key, $lower_value, $upper_value )
    {
        return $this->add( $key, [$lower_value, $upper_value], 'BETWEEN', 'NUMERIC' );
    }
}