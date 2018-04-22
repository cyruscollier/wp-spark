<?php

namespace Spark\Support\Entity;

use Spark\Model\PostEntity;

interface PostFactory extends EntityFactory
{
    function create($data): PostEntity;

    function createFromWPPost(\WP_Post $post, array $metadata = []): PostEntity;
}