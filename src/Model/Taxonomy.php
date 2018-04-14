<?php 

namespace Spark\Model;

use Spark\Model\Values\TermMetaField;

/**
 * Base class for all taxonomies
 * 
 * @author cyruscollier
 *
 */
abstract class Taxonomy extends EntityWithMetadata
{
    
    /**
     * Taxonomy must be set in sub classes
     * 
     * @var string
     */
    const TAXONOMY = null;

    public function getRegistryKey()
    {
        return static::TAXONOMY;
    }
    
    /**
     * @param string $key
     * @param mixed $value
     * @return Values\MetadataField
     */
    public function createMetadataField( $key, $value )
    {
        return new TermMetaField( $key, $value );
    }  
}