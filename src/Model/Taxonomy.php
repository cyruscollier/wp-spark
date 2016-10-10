<?php 

namespace Spark\Model;

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
    
    /**
     * @param string $key
     * @param mixed $value
     * @return MetadataField
     */
    public function createMetadataField( $key, $value )
    {
        return new TermMetaField( $key, $value );
    }  
}