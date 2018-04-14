<?php

namespace Spark\Support\Entity;

use Spark\Support\Factory;

interface EntityFactory extends Factory
{
    function __construct(EntityRegistry $Registry);
}