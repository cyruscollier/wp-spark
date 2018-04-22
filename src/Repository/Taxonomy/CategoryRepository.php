<?php

namespace Spark\Repository\Taxonomy;

use Spark\Repository\TermEntityRepository;

final class CategoryRepository extends TermEntityRepository
{
    protected static $allowed_taxonomies = 'category';
}
