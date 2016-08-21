<?php 

namespace Spark\Model\Values;

/**
 * Filtered value object for post_content
 * 
 * @author cyruscollier
 *
 */
class PostContent extends FilteredValue
{
    /**
     * Name used for filter
     *
     * @var string
     */
    protected $filter = 'the_content';
}