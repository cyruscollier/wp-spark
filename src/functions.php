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

function spark( $name = null )
{
    $container = Container::getInstance();
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