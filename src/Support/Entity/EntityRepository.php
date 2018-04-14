<?php 

namespace Spark\Support\Repository;

use Spark\Model\Entity;
use Spark\Model\EntityCollection;

/**
 * Defines basic methods for an Entity repository
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
    function findById( $id );

    /**
     * Get all Entity instances matching query parameters
     *
     * @param array $params
     * @return EntityCollection
     */
    function find( array $params = [] ): EntityCollection;

    /**
     * @return EntityCollection
     */
    function findAll(): EntityCollection;

}