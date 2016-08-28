<?php 

namespace Spark\Query\QueryBuilder;

use Spark\Query\QueryBuilder;
use Spark\Model\Metadata;
use Spark\Model\MetadataCollection;

/**
 * Base class for all types of query builder that support metadata
 * 
 * @author Cyrus
 *
 */
abstract class QueryBuilderWithMetadata implements QueryBuilder
{
    /**
     * Set in subclass
     * 
     * @var string
     */
    protected $metadata_class;
    
    /**
     * Get all metadata instances for a set of object ids
     * 
     * @param array $ids
     * @return Metadata[]
     */
    protected function getAllMetadata( array $object_ids )
    {
        $metadata_class = $this->metadata_class;
        $metadata_raw = update_meta_cache( $metadata_class::type(), $object_ids );
        $metadata = [];
        foreach ( $metadata_raw as $object_id => $fields ) {
            foreach ( $fields as $key => $value_raw ) {
                $metadata[] = $this->createMetadata( $key, $value_raw );
            }
        }
        return $metadata;
    }
    
    protected function createMetadata( $key, $value_raw )
    {
        $metadata_class = $this->metadata_class;
        if ( is_array( $value_raw ) ) {
            $metadata = new MetadataCollection();
            foreach ( $value_raw as $value ){
                $metadata->add( new $metadata_class( $key, maybe_unserialize( $value ) ) );
            }
            return $metadata;
        }
        return new $metadata_class( $key, maybe_unserialize( $value ) );
    }
    
}