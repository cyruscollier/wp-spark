<?php 

namespace Spark\Support\Entity;

use Spark\Model\EntityCollection;
use Spark\Model\PostEntity;
use Spark\Model\TermEntity;
use Spark\Model\Values\TermCompositeId;

/**
 * Defines basic methods for a taxonomy repository
 * 
 * @author cyruscollier
 *
 */
interface TermEntityRepository extends EntityRepository
{
    
    /**
     * Get Term instance matching term id
     * 
     * @param int|TermCompositeId $id
     * @return TermEntity
     */
    function findById($id): TermEntity;

    /**
     * @param array $params
     * @return TermEntity
     */
    function findOne(array $params = []): TermEntity;

    /**
     * @param string $taxonomy
     *
     * @return EntityCollection
     */
    function findAll($taxonomy = null): EntityCollection;

    /**
     * @param PostEntity $Post
     * @param string $taxonomy
     *
     * @return EntityCollection
     */
    function findForPost(PostEntity $Post, $taxonomy = null): EntityCollection;

}