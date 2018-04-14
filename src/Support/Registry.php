<?php 

namespace Spark\Support;

use Interop\Container\ContainerInterface;

interface Registry
{
    
    function __construct( ContainerInterface $Container );
    
    function register( array $classes ): array;
    
    function deregister( array $classes ): array;

    function get(string $identifier);
    
}