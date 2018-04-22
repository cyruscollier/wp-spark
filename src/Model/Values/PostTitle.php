<?php 

namespace Spark\Model\Values;

use Spark\Support\Entity\SingleEntityTitle;

/**
 * Filtered value object for post_title
 * 
 * @author cyruscollier
 *
 */
class PostTitle extends FilteredValue implements SingleEntityTitle
{
    /**
     * Name used for filter
     *
     * @var string
     */
    protected $filter = 'the_title';

    public function asSingleTitle()
    {
        return apply_filters('single_post_title', $this->value);
    }
}