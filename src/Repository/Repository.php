<?php 

namespace Spark\Repository;

use Spark\Model\EntityCollection;

/**
 * Defines basic methods for a model repository
 * 
 * @author cyruscollier
 *
 */
interface Repository
{
    
    /**
     * Get Model instance matching unique identifier
     * 
     * @param mixed $id
     * @return Model|false
     */
    public function findById( $id );
    
    /**
     * Get Model instance matching query parameters
     *
     * @param mixed $id
     * @return Model|false
     */
    public function findOne( $params );
    
    /**
     * Get all Model instances matching query parameters
     * 
     * @param array $params
     * @return EntityCollection
     */
    public function find( $params = [] );
    
    /**
     * Persist Model instance
     * 
     * @param Model $object
     */
    public function add( Model $object );
    
    /**
     * Delete Model instance
     * 
     * @param Model $object
     */
    public function remove( Model $object );
    
}