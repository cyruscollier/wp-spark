<?php 

namespace Spark\Model\Values;

/**
 * Filtered value object for post_excerpt
 * 
 * @author cyruscollier
 *
 */
class PostExcerpt extends FilteredValue
{
    /**
     * Name used for filter
     *
     * @var string
     */
    protected $filter = 'the_excerpt';
}