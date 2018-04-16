<?php 

namespace Spark\Support\Entity;

use Spark\Model\EntityCollection;
use Spark\Model\PostType;
use Spark\Model\Taxonomy;
use Spark\Model\Values\TermCompositeId;

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
     * @param int|TermCompositeId $id
     * @return Taxonomy
     */
    function findById($id): Taxonomy;

    /**
     * @param array $params
     * @return Taxonomy
     */
    function findOne(array $params = []): Taxonomy;

    /**
     * @param string $taxonomy
     *
     * @return EntityCollection
     */
    function findAll($taxonomy = null): EntityCollection;

    /**
     * @param PostType $Post
     * @param string $taxonomy
     *
     * @return EntityCollection
     */
    function findForPost(PostType $Post, $taxonomy = null): EntityCollection;

}