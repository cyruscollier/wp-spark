<?php 

namespace Spark\Support;

interface Registry
{
    function register( array $classes ): array;
    
    function deregister( array $classes ): array;
}