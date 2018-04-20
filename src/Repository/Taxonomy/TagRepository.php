<?php

namespace Spark\Repository\Taxonomy;

use Spark\Repository\TaxonomyRepository;

final class TagRepository extends TaxonomyRepository
{
    protected static $allowed_taxonomies = 'post_tag';
}
