<?php 

namespace Spark\Model\Values;

use DateTimeInterface;

/**
 * DateTime class for post date properties
 * 
 * @author cyruscollier
 *
 */
class PostDate implements DateTimeInterface 
{

    /**
     * Post published date (local time)
     * 
     * @var DateTimeInterface
     */
    protected $post_date;
    
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
    
    
    public function __construct( DateTimeInterface $post_date, DateTimeInterface $post_date_gmt )
    {
        $this->post_date = $post_date;
        $this->post_date_gmt = $post_date_gmt;
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
        $date = $this->post_date->format( $format );
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
     * 
     * {@inheritDoc}
     * @see DateTimeInterface::getTimezone()
     */
    public function getTimezone()
    {
        return $this->post_date->getTimezone();
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see DateTimeInterface::getOffset()
     */
    public function getOffset()
    {
        return $this->post_date->getOffset();
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see DateTimeInterface::getTimestamp()
     */
    public function getTimestamp()
    {
        return $this->post_date->getTimestamp();
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see DateTimeInterface::diff()
     */
    public function diff( DateTimeInterface $datetime, $absolute = null )
    {
        return $this->post_date->diff( $datetime, $absolute );
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see DateTimeInterface::__wakeup()
     */
    public function __wakeup ()
    {
        $this->post_date->__wakeup();
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
	
	public function __call( $name, $arguments = [] )
	{
	    if ( method_exists( $this->post_date, $name ) )
	        return call_user_func_array( [$this->post_date, $name], $arguments );
	    throw new \BadMethodCallException( $name );
	}
	
    
}
