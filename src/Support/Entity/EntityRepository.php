<?php 

namespace Spark\Support\Entity;

use Spark\Model\Entity;
use Spark\Support\ImmutableRepository;
use Spark\Support\Collection;

/**
 * Defines basic methods for an Entity repository
 * 
 * @author cyruscollier
 *
 */
interface EntityRepository extends ImmutableRepository
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
     * @return Collection
     */
    function find( array $params = [] ): Collection;

    /**
     * @return Collection
     */
    function findAll(): Collection;

}