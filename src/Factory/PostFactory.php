<?php

namespace Spark\Factory;

use Spark\Support\Entity\EntityRegistry;
use Spark\Model\PostType;
use Spark\Support\Entity\PostFactory as Factory;
use Spark\Model\Values;

final class PostFactory implements Factory
{
    /**
     * @var EntityRegistry
     */
    protected $Registry;

    public function __construct(EntityRegistry $Registry)
    {
        $this->Registry = $Registry;
    }

    /**
     * @param $data
     * @return PostType
     * @throws \Exception
     */
    public function create($data): PostType
    {
        $id = $data['id'] ?? null;
        $Post = $this->createInstance($data['post_type'], $id);
        $this->setIds($data, $Post);
        $this->setValues($data, $Post);
        return $Post;
    }

    /**
     * @param \WP_Post $post
     * @param array $metadata
     * @return PostType
     * @throws \Exception
     */
    function createFromWPPost(\WP_Post $post, array $metadata = []): PostType
    {
        $data = [
            'id' => $post->ID,
            'post_type' => $post->post_type,
            'parent_id' => $post->post_parent,
            'author_id' => $post->post_author,
            'title' => $post->post_title,
            'content' => $post->post_content,
            'excerpt' => get_the_excerpt( $post ),
            'status' => $post->post_status,
            'slug' => $post->post_name
        ];
        if ($post->post_date != '0000-00-00 00:00:00') {
            $data['published_date'] = $post->post_date;
        }
        if ($post->post_modified != '0000-00-00 00:00:00') {
            $data['modified_date'] = $post->post_modified;
        }
        $Post = $this->create($data);
        $Post->wp_post = $post;
        foreach ( $metadata as $key => $value) {
            $Post->setMetadata(new Values\PostMetaField($key, $value));
        }
        return $Post;
    }

    protected function createInstance($post_type, $id): PostType
    {
        $post_class = $this->Registry->getByKey($post_type);
        if (!is_a($post_class, PostType::class, true)) {
            throw new \InvalidArgumentException('Supplied post type does not have a registered PostType class:' . $post_type);
        }
        return new $post_class($id);
    }

    /**
     * @param $data
     * @param $Post
     */
    protected function setIds(&$data, PostType $Post)
    {
        foreach (['parent_id', 'author_id'] as $key) {
            if (isset($data[$key])) {
                $Post->{$key} = (int) $data[$key];
            }
        }
    }

    /**
     * @param $data
     * @param $Post
     */
    protected function setValues(&$data, PostType $Post)
    {
        $map = [
            'title' => Values\PostTitle::class,
            'content' => Values\PostContent::class,
            'excerpt' => Values\PostExcerpt::class,
            'status' => Values\PostStatus::class,
            'slug' => Values\Slug::class,
            'published_date' => Values\PostDate::class,
            'modified_date' => Values\PostModifiedDate::class
        ];
        foreach ($map as $key => $class) {
            if (isset($data[$key])) {
                $Post->{$key} = is_a($data[$key], $class, true) ?
                    $data[$key] : new $class($data[$key]);
            }
        }
    }
}