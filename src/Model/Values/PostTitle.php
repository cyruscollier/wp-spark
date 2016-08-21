<?php 

namespace Spark\Model\Values;

/**
 * Filtered value object for post_title
 * 
 * @author cyruscollier
 *
 */
class PostTitle extends FilteredValue
{
    /**
     * Name used for filter
     *
     * @var string
     */
    protected $filter = 'the_title';
}