<?php 

namespace Spark\Support\Entity;

use Spark\Model\EntityCollection;
use Spark\Model\PostType;
use Spark\Model\Values\PostDate;
use Spark\Model\Values\PostStatus;

/**
 * Defines basic methods for a post type repository
 * 
 * @author cyruscollier
 *
 */
interface PostTypeRepository extends EntityRepository
{
    
    /**
     * Get Post instance matching post id
     * 
     * @param int $id
     * @return PostType
     */
    function findById($id): PostType;

    /**
     * @param array $params
     * @return PostType
     */
    function findOne(array $params = []): PostType;

    function findByAuthor(int $author_id): EntityCollection;

    function findWithStatus(PostStatus $status): EntityCollection;

    function findPublishedOn(PostDate $date): EntityCollection;

    function findPublishedBefore(PostDate $date): EntityCollection;

    function findPublishedAfter(PostDate $date): EntityCollection;

}