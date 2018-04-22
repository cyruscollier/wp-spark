<?php

namespace Spark\Repository\PostType;

use Spark\Repository\PostEntityRepository;

final class PostRepository extends PostEntityRepository
{
    protected static $allowed_post_types = 'post';
}
