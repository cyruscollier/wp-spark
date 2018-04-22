<?php

namespace Spark\Repository\PostType;

use Spark\Repository\PostEntityRepository;

final class PageRepository extends PostEntityRepository
{
    protected static $allowed_post_types = 'page';
}
