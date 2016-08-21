<?php 

namespace Spark\Model\Values;

/**
 * Base class for values that have an associated filter
 * 
 * @author cyruscollier
 *
 */
abstract class FilteredValue
{
    
    /**
     * Raw value
     * 
     * @var mixed
     */
    protected $value;
    
    /**
     * Name used for filter, set in subclasses
     * 
     * @var string
     */
    protected $filter;
    
    /**
     * Whether to use filtered value as default
     * 
     * @var boolean
     */
    protected $filtered_default = true;
    
    /**
     * Set value
     * 
     * @param mixed $value
     */
    public function __construct( $value )
    {
        $this->value = $value;
    }
    
    /**
     * Get filtered value
     * 
     * @return mixed
     */
    public function filtered()
    {
        return apply_filters( $this->filter, $this->value );
    }
    
    /**
     * Get value without filter
     * 
     * @return mixed
     */
    public function raw()
    {
        return $this->value;
    }
    
    /**
     * Get default filtered/raw version of value
     * 
     * @return mixed
     */
    public function getValue()
    {
        return $this->filtered_default ? $this->filtered() : $this->raw();
    }
    
    /**
     * Default version value as string
     * 
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getValue();
    }    
    
}
