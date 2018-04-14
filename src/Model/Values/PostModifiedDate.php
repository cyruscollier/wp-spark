<?php 

namespace Spark\Model\Values;

/**
 * Variation of PostDate for post_modified_date
 * 
 * @author cyruscollier
 *
 */
class PostModifiedDate extends PostDate
{
    
    /**
     * Name used for date filter
     * 
     * @var string
     */
    protected $filter = 'get_the_modified_date';

    
}
