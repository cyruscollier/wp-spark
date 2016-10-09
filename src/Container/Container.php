<?php

namespace Spark\Container;

use DI\Container as DIContainer;
use DI\Definition\Helper\DefinitionHelper;

/**
 * Dependency injection container, wraps DI container with static singleton facade
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
    
    public static function getInstance()
    {
        if ( !static::$instance ) {
            $ContainerFactory = new ContainerFactory();
            static::$instance = $ContainerFactory->create();
        }
        return static::$instance;
    }
    
    public static function __callStatic( $method, $arguments )
    {
        $Container = self::getInstance();
        return call_user_func_array( [$Container, $method], $arguments );
    }
}
