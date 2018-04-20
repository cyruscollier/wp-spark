<?php

namespace Spark\Repository\Taxonomy;

use Spark\Repository\TaxonomyRepository;

final class CategoryRepository extends TaxonomyRepository
{
    protected static $allowed_taxonomies = 'category';
}
