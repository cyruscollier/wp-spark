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
    
    /**
     * Name used for date filter when getting GMT time
     *
     * @var string
     */
    protected $filter_gmt = 'get_post_modified_time';    
    
}
