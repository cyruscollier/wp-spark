<?php 

namespace Spark\Model\Values;

use Cake\Chronos\Chronos;

/**
 * DateTime class for post date properties
 * 
 * @author cyruscollier
 *
 */
class PostDate extends Chronos
{
    /**
     * Name used for date filter
     * 
     * @var string
     */
    protected $filter = 'get_the_date';
    
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
     * Default formatted date
     * 
     * @return string
     */
    public function __toString()
    {
        return (string) $this->defaultFormat();
    }
    
}
