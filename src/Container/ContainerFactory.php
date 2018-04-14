<?php

namespace Spark\Container;

use DI\ContainerBuilder;
use DI\Container as DIContainer;

/**
 * Creates an instance of DI Container with definitions
 * 
 * @author cyruscollier
 *
 */
class ContainerFactory
{
    protected $ContainerBuilder;
    
    protected $default_config_locations;
    
    public function __construct( ContainerBuilder $ContainerBuilder = null )
    {
        $this->ContainerBuilder = $ContainerBuilder ?: new ContainerBuilder();
        $this->default_config_locations = [
            SPARK_PATH . 'src/container-config.php',
            WP_CONTENT_DIR . 'spark-container-config.php'
        ];
    }

    /**
     * @return DIContainer
     * @throws \Exception
     */
    public function create()
    {
        $config_locations = spark_filter( 'container_config', $this->default_config_locations );
        $this->ContainerBuilder->addDefinitions( $config_locations );
        return $this->ContainerBuilder->build();
    }
}