<?php

namespace Spark\Container;

use DI\ContainerBuilder;
use DI\Container as DIContainer;
use DI\Definition\Helper\DefinitionHelper;

/**
 * Dependency injection container, wraps DI container with static facade
 * 
 * @author cyruscollier
 * 
 * @method static mixed get(string $name)
 * @method static mixed make(string $name, array $parameters = [])
 * @method static mixed has(string $name)
 * @method static object injectOn(object $instance)
 * @method static mixed call(callable $callable, array $parameters = [])
 * @method static set(string $name, mixed|DefinitionHelper $value)
 *
 */
class Container
{
    /**
     * @var DIContainer
     */
    protected static $instance;

    public static function build()
    {
        if ( !class_exists( 'DI\ContainerBuilder' ) ) return;
        $ContainerBuilder = new ContainerBuilder;
        $config_locations = [
            SPARK_PATH . 'src/container-config.php',
            WP_CONTENT_DIR . 'spark-container-config.php'
        ];
        $config_locations = spark_filter( 'container_config', $config_locations );
        foreach ( $config_locations as $file ) {
            $ContainerBuilder->addDefinitions( $file );
        }
        static::$instance = $ContainerBuilder->build();
    }
    
    public static function getInstance()
    {
        if ( !static::$instance ) static::build();
        return static::$instance;
    }
    
    public static function __callStatic( $method, $arguments )
    {
        if ( !static::$instance ) static::build();
        return call_user_func_array( [static::$instance, $method], $arguments );
    }
}
