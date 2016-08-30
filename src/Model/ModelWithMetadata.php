<?php 

namespace Spark\Model;

use Spark\Model\Values\MetadataField;

/**
 * Models that support metadata fields
 * 
 * @author cyruscollier
 *
 */
abstract class ModelWithMetadata extends Model
{
    
    /**
     * @var Metadata[]
     */
    protected $_metadata = [];

    public function setMetadata( Metadata $metadata )
    {
        $key = $metadata->getKey();
        $this->_metadata[$key] = isset( $this->_metadata[$key] ) ?
            $this->_metadata[$key]->update( $metadata ) :
            $metadata;
    }
    
    public function __get( $name )
    {
        if ( $value = parent::__get( $name ) )
            return $value;
        if ( array_key_exists( $name, $this->_metadata ) )
            return $this->_metadata[$name];
    }
    
    public function __set( $name, $value )
    {
        if ( false !== parent::__set( $name, $value ) ) {
            return;
        }
        if ( !( $value instanceof Metadata ) ) {
            $value = $this->createMetadataField( $name, $value );
        }
        $this->setMetadata( $value );
    }
    
    public function getMetadataType()
    {
        return $this->createMetadataField( '', '' )->getType();
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return MetadataField
     */
    public abstract function createMetadataField( $key, $value );
    
}