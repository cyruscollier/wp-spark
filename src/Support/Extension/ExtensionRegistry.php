<?php 

namespace Spark\Support\Extension;

use Psr\Container\ContainerInterface;
use Spark\Support\Registry;

interface ExtensionRegistry extends Registry
{
    public function __construct( ContainerInterface $Container );
}