<?php 

namespace Spark\Support\Entity;

use Spark\Model\EntityCollection;
use Spark\Model\PostEntity;
use Spark\Model\Values\PostDate;
use Spark\Model\Values\PostStatus;

/**
 * Defines basic methods for a post type repository
 * 
 * @author cyruscollier
 *
 */
interface PostEntityRepository extends EntityRepository
{
    
    /**
     * Get Post instance matching post id
     * 
     * @param int $id
     * @return PostEntity
     */
    function findById($id): PostEntity;

    /**
     * @param array $params
     * @return PostEntity
     */
    function findOne(array $params = []): PostEntity;

    function findByAuthor(int $author_id): EntityCollection;

    function findWithStatus(PostStatus $status): EntityCollection;

    function findPublishedOn(PostDate $date): EntityCollection;

    function findPublishedBefore(PostDate $date): EntityCollection;

    function findPublishedAfter(PostDate $date): EntityCollection;

}