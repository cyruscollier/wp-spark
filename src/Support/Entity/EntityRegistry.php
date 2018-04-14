<?php 

namespace Spark\Support\Entity;

use Spark\Model\Entity;
use Spark\Support\Registry;

interface EntityRegistry extends Registry
{
    function getByKey(string $key): Entity;
}