<?php

use Spark\Extension as Extension;
use Spark\Model as Model;
use Spark\Query as Query;
use Spark\Support as Support;

use function DI\autowire;

return [
    Support\Extension\ExtensionRegistry::class => autowire(Extension\ExtensionRegistry::class),
    Support\Entity\EntityRegistry::class => autowire(Model\EntityRegistry::class),
    Support\Query\PostTypeQueryBuilder::class => autowire(Query\PostTypeQueryBuilder::class),
    Support\Query\TaxonomyQueryBuilder::class => autowire(Query\TaxonomyQueryBuilder::class)
];