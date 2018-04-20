<?php

namespace Spark\Repository\PostType;

use Spark\Repository\PostTypeRepository;

final class PostRepository extends PostTypeRepository
{
    protected static $allowed_post_types = 'post';
}
