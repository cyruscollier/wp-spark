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
    protected $query_key = 'tax_query';
    protected $clause_value_key = 'terms';

    /**
     * Adds clause
     *
     * @param string $taxonomy
     * @param mixed $terms
     * @param string $operator
     * @param string $field
     * @return $this
     */
    public function add( $taxonomy, $terms, $operator = 'IN', $field = 'slug' )
    {
        if ( !is_array( $terms ) ) $terms = [$terms];
        return $this->addClause( compact( 'taxonomy', 'terms', 'operator', 'field' ) );
    }
}