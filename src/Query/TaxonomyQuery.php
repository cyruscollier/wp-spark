<?php

namespace Spark\Query;

/**
 * Builds query clauses for 'tax_query' variable of WP_Query
 *
 * @author cyruscollier
 *
 */
class TaxonomyQuery extends SubQuery
{

    /**
     * Adds clause
     *
     * @param string $taxonomy
     * @param mixed $terms
     * @param string $operator
     * @param string $field
     * @return $this
     */
    function add( $taxonomy, $terms, $operator = 'IN', $field = 'slug' )
    {
        if ( !is_array( $terms ) ) $terms = [$terms];
        return $this->addClause( compact( 'taxonomy', 'terms', 'operator', 'field' ) );
    }
    
    /**
     * Name of query key to user for this subquery
     *
     * @return string
     */
    function getQueryKey()
    {
        return 'tax_query';
    }
    
    /**
     * Gets value inside of clause
     *
     * @param array $clause
     * @return mixed
     */
    protected function getClauseValue( array $clause )
    {
        return $clause['terms'];
    }
    
    
}