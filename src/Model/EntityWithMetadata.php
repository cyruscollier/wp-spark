<?php 

namespace Spark\Model;

use Spark\Model\Values\MetadataField;
use Spark\Model\Values\Permalink;
use Spark\Support\Entity\HasPermalink;

/**
 * Models that support metadata fields
 * 
 * @author cyruscollier
 *
 * @property
 *
 */
abstract class EntityWithMetadata extends Entity implements HasPermalink
{
    protected $permalink;

    /**
     * @var MetadataField[]
     */
    protected $_metadata = [];

    public function setMetadata( MetadataField $metadata )
    {
        $key = $metadata->getKey();
        $this->_metadata[$key] = isset( $this->_metadata[$key] ) ?
            $this->_metadata[$key]->update( $metadata ) :
            $metadata;
    }

    function getPermalink(): Permalink
    {
        $this->permalink;
    }

    function setPermalink(Permalink $permalink)
    {
        $this->permalink = $permalink;
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
        if ( !( $value instanceof MetadataField ) ) {
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