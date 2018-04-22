<?php

namespace Spark\Support\Entity;

use Spark\Model\TermEntity;

interface TermFactory extends EntityFactory
{
    function create($data): TermEntity;

    function createFromWPTerm(\WP_Term $term, array $metadata = []): TermEntity;
}