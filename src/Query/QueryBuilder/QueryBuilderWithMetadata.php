<?php 

namespace Spark\Query\QueryBuilder;

use Spark\Query\QueryBuilder;
use Spark\Model\Metadata;
use Spark\Model\MetadataCollection;
use Spark\Model\ModelWithMetadata;

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
    protected $base_model_class = ModelWithMetadata::class;
    
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
        $model = $this->createModel();
        if ( is_array( $value_raw ) ) {
            $metadata = new MetadataCollection();
            foreach ( $value_raw as $value ){
                $metadata->add( $model->createMetadataField( $key, $value ) );
            }
            return $metadata;
        }
        return $model->createMetadataField( $key, $value );
    }
    
    /**
     * @return ModelWithMetadata
     */
    abstract protected function createModel();
    
}