<?php

use Spark\Container\Container;
/**
 * Global utility and convenience function
 * 
 * @author cyruscollier
 *
 */

define( 'SPARK_PATH', dirname( __DIR__ ) );
define( 'SPARK_TEXT_DOMAIN', 'spark' );

/**
 * @param string $name
 * @return \DI\Container|mixed
 * @throws \DI\DependencyException
 * @throws \DI\NotFoundException
 */
function spark( $name = '' )
{
    static $container;
    if ( !$container ) {
        $ContainerFactory = new \Spark\Container\ContainerFactory();
        $container = $ContainerFactory->create();
    }
    return $name ? $container->get( $name ) : $container;
}

function spark_filter( $tag, $value )
{
    $args = func_get_args();
    $args[0] = 'spark_' . $args[0];
    return call_user_func_array( 'apply_filters', $args );
}

function spark_action( $tag )
{
    $args = func_get_args();
    $args[0] = 'spark_' . $args[0];
    return call_user_func_array( 'do_action', $args );
}

function spark_to_pascal_case( $name )
{
    return str_replace( ' ', '', ucwords( str_replace( '_', ' ', $name ) ) );
}

function spark_to_snake_case( $name )
{
    return ltrim( strtolower( preg_replace( '/[A-Z]/', '_$0', $name ) ), '_' );
}