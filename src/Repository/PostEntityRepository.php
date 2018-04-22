<?php

namespace Spark\Repository;

use Spark\Model\Values\Permalink;
use Spark\Query\DateQuery;
use Spark\Support\Entity\PostFactory;
use Spark\Model\EntityCollection;
use Spark\Model\PostEntity;
use Spark\Model\Values\PostDate;
use Spark\Model\Values\PostStatus;
use Spark\Support\Query\PostQueryBuilder;
use Spark\Support\Entity\PostEntityRepository as Repository;
use Spark\Support\Entity\TermEntityRepository;

class PostEntityRepository implements Repository
{
    protected $Query;

    protected $Factory;

    protected $Repository;

    protected static $allowed_post_types = [];

    public function __construct(PostQueryBuilder $Query, PostFactory $Factory, TermEntityRepository $Repository)
    {
        $this->Query = $Query;
        $this->Factory = $Factory;
        $this->Repository = $Repository;
    }

    function find(array $params = []): EntityCollection
    {
        $this->Query->where($params);
        return $this->getPosts();
    }

    function findAll(): EntityCollection
    {
        $this->Query->all();
        return $this->getPosts();
    }

    /**
     * @param int $id
     * @return PostEntity
     * @throws \Exception
     */
    function findById($id): PostEntity
    {
        $post = get_post($id);
        return $this->getPost($post);
    }

    function findOne(array $params = []): PostEntity
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
        $this->Query->withSubQuery((new DateQuery())->add($date));
        return $this->getPosts();
    }

    function findPublishedBefore(PostDate $date): EntityCollection
    {
        $this->Query->withSubQuery((new DateQuery())->addBefore($date));
        return $this->getPosts();
    }

    function findPublishedAfter(PostDate $date): EntityCollection
    {
        $this->Query->withSubQuery((new DateQuery())->addAfter($date));
        return $this->getPosts();
    }

//    public function add($object)
//    {
//        // TODO: Implement add() method.
//    }
//
//    public function remove($object)
//    {
//        // TODO: Implement remove() method.
//    }

    /**
     * @param \WP_Post $post
     * @return PostEntity
     * @throws \Exception
     */
    protected function getPost(\WP_Post $post)
    {
        $post_type = $this->getPostType();
        if ($post_type && !in_array($post->post_type, $post_type)) {
            throw new \InvalidArgumentException('Post does not match allowed post type(s)');
        }
        $raw_metadata = get_post_meta($post->ID);
        $metadata = array_map(function($m) {
            return $m[0];
        }, $raw_metadata);
        $Post = $this->Factory->createFromWPPost($post, $metadata);
        $Post->setPermalink(new Permalink(get_permalink($post->ID)));
        $Post->setTermsReference([$this->Repository, 'findForPost']);
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
            $Post = $this->getPost($post);
            $Collection->add($Post);
        }
        return $Collection;
    }

    protected function getPostType()
    {
        return static::$allowed_post_types ? (array) static::$allowed_post_types : [];
    }

}