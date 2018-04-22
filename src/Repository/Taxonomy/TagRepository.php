<?php

namespace Spark\Repository\Taxonomy;

use Spark\Repository\TermEntityRepository;

final class TagRepository extends TermEntityRepository
{
    protected static $allowed_taxonomies = 'post_tag';
}
