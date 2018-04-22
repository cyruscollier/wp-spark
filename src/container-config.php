<?php

use Spark\Extension as Extension;
use Spark\Model as Model;
use Spark\Query as Query;
use Spark\Support as Support;

use function DI\autowire;

return [
    Support\Extension\ExtensionRegistry::class => autowire(Extension\ExtensionRegistry::class),
    Support\Entity\EntityRegistry::class => autowire(Model\EntityRegistry::class),
    Support\Query\PostQueryBuilder::class => autowire(Query\PostQueryBuilder::class),
    Support\Query\TermQueryBuilder::class => autowire(Query\TermQueryBuilder::class)
];