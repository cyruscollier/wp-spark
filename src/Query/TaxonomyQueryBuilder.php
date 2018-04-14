<?php 

namespace Spark\Query;

/**
 * Query Builder for all post types
 * 
 * @author ccollier
 *
 */
class TaxonomyQueryBuilder extends QueryBuilder implements \Spark\Support\Query\TaxonomyQueryBuilder
{

    public function all()
    {
        $this->parameters['hide_empty'] = true;
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