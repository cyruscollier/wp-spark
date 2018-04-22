<?php 

namespace Spark\Query;

/**
 * Query Builder for all post types
 * 
 * @author ccollier
 *
 */
class TermQueryBuilder extends QueryBuilder implements \Spark\Support\Query\TermQueryBuilder
{

    public function all()
    {
        $this->parameters['hide_empty'] = false;
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
        $this->parameters['number'] = (int) $limit;
        return $this;
    }

    function withTaxonomy($taxonomy)
    {
        $this->parameters['taxonomy'] = $taxonomy;
        return $this;
    }


}