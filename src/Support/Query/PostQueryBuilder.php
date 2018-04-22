<?php 

namespace Spark\Support\Query;

interface PostQueryBuilder extends QueryBuilder
{
    /**
     * @param $post_type
     *
     * @return $this
     */
    function withPostType($post_type);

    /**
     * Specify page count
     *
     * @param int $page
     *
     * @return $this
     */
    function page($page);
    
}