<?php 

namespace Spark\Support\Entity;

use Spark\Model\PostEntity;
use Spark\Model\Values\PostDate;
use Spark\Model\Values\PostStatus;
use Spark\Support\Collection;

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

    function findByAuthor(int $author_id): Collection;

    function findWithStatus(PostStatus $status): Collection;

    function findPublishedOn(PostDate $date): Collection;

    function findPublishedBefore(PostDate $date): Collection;

    function findPublishedAfter(PostDate $date): Collection;

}