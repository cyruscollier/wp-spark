<?php 

namespace Spark\Query\QueryBuilder;

use Spark\Query\QueryBuilder;
use Spark\Model\Metadata;
use Spark\Model\MetadataCollection;
use Spark\Model\EntityWithMetadata;

/**
 * Base class for all types of query builder that support metadata
 * 
 * @author Cyrus
 *
 */
abstract class QueryBuilderWithMetadata implements QueryBuilder
{
    
    /**
     * Bound model class name
     *
     * @var string
     */
    protected $model_class;
    
    /**
     * Parent model class of bounded class, override in subclasses
     * 
     * @var string
     */
    protected $base_model_class = EntityWithMetadata::class;
    
    /**
     * List of parameters for get_posts()
     *
     * @var array
     */
    protected $parameters = [];
    
    /**
     * Stored after each query
     *
     * @var Collection
     */
    protected $previousCollection;
    
    /**
     * Constructor checks if provided model class name is a PostType
     *
     * @param string $model_class
     * @throws \InvalidArgumentException
     */
    public function __construct( $model_class )
    {
        $this->reset( $model_class );
    }
    
    /**
     * Clears parameters and previous Collection, rebinds to a model class
     *
     * @param string $model_class
     */
    public function reset( $model_class ) {
        if ( !is_a( $model_class, $this->base_model_class, true ) ) {
            throw new \InvalidArgumentException( 
                'Provided class name is not an instance of ' . $this->base_model_class );
        }
        $this->model_class = $model_class;
        $this->parameters = [];
        $this->previousCollection = null;
        return $this;
    }
    
    
    /**
     * Get all metadata instances for a set of object ids
     * 
     * @param array $ids
     * @return Metadata[]
     */
    protected function getAllMetadata( array $object_ids )
    {
        $model = $this->createModel();
        $metadata_raw = update_meta_cache( $model->getMetadataType(), $object_ids );
        $metadata = [];
        foreach ( $metadata_raw as $object_id => $fields ) {
            $metadata[$object_id] = [];
            foreach ( $fields as $key => $value_raw ) {
                $metadata[$object_id][] = $this->createMetadata( $model, $key, $value_raw );
            }
        }
        return $metadata;
    }
    
    protected function createMetadata( EntityWithMetadata $model, $key, $value_raw )
    {
        return $model->createMetadataField( $key, $value_raw );
    }    
    
    /**
     * @return EntityWithMetadata
     */
    protected function createModel()
    {
        return new $this->model_class;
    }
    
}