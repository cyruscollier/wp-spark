<?php

namespace Spark\Repository\PostType;

use Spark\Repository\PostTypeRepository;

final class PageRepository extends PostTypeRepository
{
    protected static $allowed_post_types = 'page';
}
