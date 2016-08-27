<?php 

namespace Spark\Model\Values;

use DateTimeImmutable, DateTimeInterface;

/**
 * DateTime class for post date properties
 * 
 * @author cyruscollier
 *
 */
class PostDate extends DateTimeImmutable 
{
    
    /**
     * Post published date (GMT)
     * 
     * @var DateTimeInterface
     */
    protected $post_date_gmt;
    
    /**
     * Name used for date filter
     * 
     * @var string
     */
    protected $filter = 'get_the_date';
    
    /**
     * Name used for date filter when getting GMT time
     *
     * @var string
     */
    protected $filter_gmt = 'get_post_time';
    
    
    public function __construct( $post_date, $post_date_gmt )
    {
        parent::__construct( $post_date );
        $this->post_date_gmt = new DateTimeImmutable( $post_date_gmt );
    }
    
    public function defaultFormat()
    {
        return $this->format( get_option( 'date_format' ) );
    }
    
    /**
     * Applies filter to formatted date
     * 
     * {@inheritDoc}
     * @see DateTimeInterface::format()
     */
    public function format( $format )
    {
        $date = parent::format( $format );
        return apply_filters( $this->filter, $date, $format );
    }

    /**
     * Applies gmt filter to formatted gmt date
     * 
     * @param string $format
     */
    public function formatGMT( $format )
    {
        $date = $this->post_date_gmt->format( $format );
        return apply_filters( $this->filter_gmt, $date, $format );
    }
    
    /**
     * Default formatted date
     * 
     * @return string
     */
    public function __toString()
    {
        return (string) $this->defaultFormat();
    }
    
}
