<?php 

namespace Spark\Query;

/**
 * Query Builder for all post types
 * 
 * @author ccollier
 *
 */
final class PostQueryBuilder extends QueryBuilder implements \Spark\Support\Query\PostQueryBuilder
{

    public function all()
    {
        $this->parameters['posts_per_page'] = -1;
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
        $this->parameters['posts_per_page'] = (int) $limit;
        return $this;
    }
    
    /**
     * Specify page count
     * 
     * @param int $page
     * @return $this
     */
    public function page( $page )
    {
        $this->parameters['paged'] = (int) $page;
        return $this;
    }

    function withPostType($post_type)
    {
        $this->parameters['post_type'] = $post_type;
        return $this;
    }

}