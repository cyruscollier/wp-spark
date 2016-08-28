<?php 

namespace Spark\Model\Values;

/**
 * Representation of one metadata field
 * 
 * @author cyruscollier
 *
 */
abstract class MetadataField implements Metadata
{
    
    /**
     * Metadata type, set in subclass
     * @var string
     */
    protected $type;
    
    /**
     * @var string
     */
    protected $key;
    
    /**
     * @var mixed
     */
    protected $value = '';
    
    /**
     * Previous set value, used to match when persisting
     * @var unknown
     */
    protected $previous;
    
    public function __construct( $meta_key, $meta_value )
    {
        $this->key = $meta_key;
        $this->value = $meta_value;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function getKey()
    {
        return $this->key;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function getIndex()
    {
        return (string) $this->previous ? $this->previous : $this->value;
    }
    
    
    public function __toString()
    {
        return (string) $this->getValue();
    }
    
    public function toCollection()
    {
        return new MetadataCollection($meta_key, $meta_value)
    }
}