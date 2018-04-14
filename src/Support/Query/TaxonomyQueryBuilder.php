<?php 

namespace Spark\Support\Query;

interface TaxonomyQueryBuilder extends QueryBuilder
{
    /**
     * @param $taxonomy
     *
     * @return $this
     */
    function withTaxonomy($taxonomy);
    
}