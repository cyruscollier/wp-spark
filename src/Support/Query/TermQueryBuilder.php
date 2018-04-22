<?php 

namespace Spark\Support\Query;

interface TermQueryBuilder extends QueryBuilder
{
    /**
     * @param $taxonomy
     *
     * @return $this
     */
    function withTaxonomy($taxonomy);
    
}