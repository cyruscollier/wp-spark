<?php 

namespace Spark\Model\Values;

use Spark\Model\MetadataCollection;
use Spark\Model\Metadata;

/**
 * Representation of one metadata field
 * 
 * @author cyruscollier
 *
 */
abstract class MetadataField implements Metadata
{
    
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
        $this->value = maybe_unserialize( $meta_value );
    }
    
    public function getKey()
    {
        return $this->key;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function __toString()
    {
        return (string) $this->getValue();
    }
    
    public function update( $value )
    {
        if ( $value instanceof static ) {
            $value = $value->getValue();
        }
        $field = new static( $this->key, $value );
        $field->previous = $this->value;
        return $field;
    }

}