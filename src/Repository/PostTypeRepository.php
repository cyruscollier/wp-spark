<?php

namespace Spark\Repository;

use Spark\Model\Values\Permalink;
use Spark\Support\Entity\PostFactory;
use Spark\Model\EntityCollection;
use Spark\Model\PostType;
use Spark\Model\Values\PostDate;
use Spark\Model\Values\PostStatus;
use Spark\Support\Query\PostTypeQueryBuilder;
use Spark\Support\Entity\PostTypeRepository as Repository;

class PostTypeRepository implements Repository
{
    protected $Query;

    protected $Factory;

    public function __construct(PostTypeQueryBuilder $Query, PostFactory $Factory)
    {
        $this->Query = $Query;
        $this->Factory = $Factory;
    }

    function find(array $params = []): EntityCollection
    {
        $this->Query->where($params);
        return $this->getPosts();
    }

    function findAll(): EntityCollection
    {
        // TODO: Implement findAll() method.
    }

    /**
     * @param int $id
     * @return PostType
     * @throws \Exception
     */
    function findById($id): PostType
    {
        $post = get_post($id);
        return $this->getPost($post);
    }

    function findOne(array $params = []): PostType
    {
        $this->Query->one();
        $Collection = $this->getPosts();
        return $Collection[0];
    }

    function findByAuthor(int $author_id): EntityCollection
    {
        $this->Query->where(['author' => $author_id]);
        return $this->getPosts();
    }

    function findWithStatus(PostStatus $status): EntityCollection
    {
        $this->Query->where(['post_status' => (string) $status]);
        return $this->getPosts();
    }

    function findPublishedOn(PostDate $date): EntityCollection
    {
        /* TODO: Make and use DateQuery */
        $this->Query->where(['date_query' => [
            ['year' => $date->year, 'month' => $date->month, 'day' => $date->day]
        ]]);
        return $this->getPosts();
    }

    function findPublishedBefore(PostDate $date): EntityCollection
    {
        /* TODO: Make and use DateQuery */
        $this->Query->where(['date_query' => [
            ['before' => $date->toDateTimeString()]
        ]]);
        return $this->getPosts();
    }

    function findPublishedAfter(PostDate $date): EntityCollection
    {
        /* TODO: Make and use DateQuery */
        $this->Query->where(['date_query' => [
            ['after' => $date->toDateTimeString()]
        ]]);
        return $this->getPosts();
    }

    public function add($object)
    {
        // TODO: Implement add() method.
    }

    public function remove($object)
    {
        // TODO: Implement remove() method.
    }

    /**
     * @param \WP_Post $post
     * @return PostType
     * @throws \Exception
     */
    protected function getPost(\WP_Post $post)
    {
        $raw_metadata = get_post_meta($post->ID);
        $metadata = array_map(function($m) {
            return $m[0];
        }, $raw_metadata);
        $Post = $this->Factory->createFromWPPost($post, $metadata);
        $Post->setPermalink(new Permalink(get_permalink($post->ID)));
        return $Post;
    }

    protected function getPosts()
    {
        if ($post_type = $this->getPostType()) {
            $this->Query->withPostType($post_type);
        }
        $posts = get_posts($this->Query->build());
        $Collection = new EntityCollection();
        foreach ($posts as $post) {
            try {
                $Post = $this->getPost($post);
                $Collection->add($Post);
            } catch (\Exception $e) {
                error_log($e->getMessage());
            }
        }
        return $Collection;
    }

    protected function getPostType()
    {
        return false;
    }

}