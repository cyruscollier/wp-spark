<?php

namespace Spark\Support\Entity;

use Spark\Model\Taxonomy;

interface TermFactory extends EntityFactory
{
    function create($data): Taxonomy;

    function createFromWPTerm(\WP_Term $term, array $metadata = []): Taxonomy;
}