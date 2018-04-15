<?php

namespace Spark\Factory;

use Spark\Model\Taxonomy;
use Spark\Support\Entity\EntityRegistry;
use Spark\Support\Entity\TermFactory as Factory;

final class TermFactory implements Factory
{
    /**
     * @var EntityRegistry
     */
    protected $Registry;

    public function __construct(EntityRegistry $Registry)
    {
        $this->Registry = $Registry;
    }


    public function create($data): Taxonomy
    {

    }

    function createFromWPTerm(\WP_Term $term, array $metadata = []): Taxonomy
    {

    }
}