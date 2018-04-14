<?php 

namespace Spark\Support\Entity;

use Spark\Model\Taxonomy;

/**
 * Defines basic methods for a taxonomy repository
 * 
 * @author cyruscollier
 *
 */
interface TaxonomyRepository extends EntityRepository
{
    
    /**
     * Get Term instance matching term id
     * 
     * @param int $id
     * @return Taxonomy
     */
    function findById($id): Taxonomy;

    /**
     * @param array $params
     * @return Taxonomy
     */
    function findOne(array $params = []): Taxonomy;

}