<?php

namespace Spark\Support\Entity;

use Spark\Model\PostType;

interface PostFactory extends EntityFactory
{
    function create($data): PostType;

    function createFromWPPost(\WP_Post $post, array $metadata = []): PostType;
}