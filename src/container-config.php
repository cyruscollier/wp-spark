<?php

use Spark\Extension as Extension;
use Spark\Model as Model;
use Spark\Support as Support;

use function DI\autowire;

return [
    Support\Extension\ExtensionRegistry::class => autowire(Extension\ExtensionRegistry::class),
    Support\Entity\EntityRegistry::class => autowire(Model\EntityRegistry::class)
];