<?php 

namespace Spark\Support\Repository;

use Spark\Model\Entity;
use Spark\Model\EntityCollection;

/**
 * Defines basic methods for a model repository
 * 
 * @author cyruscollier
 *
 */
interface EntityRepository extends Repository
{
    
    /**
     * Get Entity instance matching unique identifier
     * 
     * @param mixed $id
     * @return Entity
     */
    public function findById( $id ): Entity;
    
    /**
     * Get Entity instance matching query parameters
     *
     * @param array $params
     * @return Entity
     */
    public function findOne( array $params = [] ): Entity;
    
    /**
     * Get all Entity instances matching query parameters
     * 
     * @param array $params
     * @return EntityCollection
     */
    public function find( array $params = [] ): EntityCollection;
    
}