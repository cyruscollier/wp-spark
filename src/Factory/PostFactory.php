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
    public function create($data): PostType {
        $Post = $this->createInstance($data['post_type']);
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
    function createFromWPPost(\WP_Post $post, array $metadata = []): PostType {
        $data = [
            'id' => $post->ID,
            'parent_id' => $post->post_parent,
            'author_id' => $post->post_author,
            'title' => $post->post_title,
            'content' => $post->post_content,
            'excerpt' => get_the_excerpt( $post ),
            'status' => $post->post_status,
            'slug' => $post->post_name,
            'published_date' => $post->post_date,
            'modified_date' => $post->post_modified,
        ];
        $Post = $this->create($data);
        $Post->wp_post = $post;
        foreach ( $metadata as $field ) {
            $Post->setMetadata( $field );
        }
        return $Post;
    }

    protected function createInstance($post_type): PostType
    {
        $post_class = $this->Registry->getByKey($post_type);
        if (!is_a($post_class, PostType::class, true)) {
            throw new \InvalidArgumentException('Supplied post type does not have a registered PostType class:' . $post_type);
        }
        return new $post_class;
    }

    /**
     * @param $data
     * @param $Post
     */
    protected function setIds(&$data, PostType $Post)
    {
        foreach (['id', 'parent_id', 'author_id'] as $key) {
            if (isset($data[$key])) {
                $Post->{$key} = (int) $data['key'];
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