<?php 

namespace Spark\Support\Entity;

use Spark\Model\Entity;
use Spark\Model\EntityCollection;
use Spark\Support\Repository;

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