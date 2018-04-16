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

    protected static $metadata_type = MetadataField::class;

    /**
     * @var MetadataField[]
     */
    protected $_metadata = [];

    public function setMetadata( MetadataField $metadata )
    {
        $this->checkMetadataType($metadata);
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
    
    protected function checkMetadataType(MetadataField $metadata)
    {
        if (! $metadata instanceof static::$metadata_type) {
            throw new \InvalidArgumentException('Metadata object must be of type: ' . static::$metadata_type);
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return MetadataField
     */
    protected function createMetadataField( $key, $value )
    {
        $class = static::$metadata_type;
        return new $class($key, $value);
    }
    
}