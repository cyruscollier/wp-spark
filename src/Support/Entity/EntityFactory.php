<?php

namespace Spark\Support\Entity;

use Spark\Model\Entity;

interface EntityFactory
{
    function __construct(EntityRegistry $Registry);

    function create($data): Entity;
}