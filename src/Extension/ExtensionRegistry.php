<?php 

namespace Spark\Extension;

use Interop\Container\ContainerInterface;
use Spark\Support\Registry;

final class ExtensionRegistry implements Registry
{
    
    /**
     * @var ContainerInterface
     */
    protected $Container;
    
    /**
     * Complete reference of registered extensions
     * @var array
     */
    protected $extensions = [];
    
    public function __construct( ContainerInterface $Container )
    {
        $this->Container = $Container;
    }
    
    public function register(array $extensions_classes ): array
    {
        $registered_extensions = [];
        foreach ( $extensions_classes as $extension_class ) {
            $Extension = $this->getExtensionInstance( $extension_class );
            if ( !$Extension->isRegistered() ) {
                $Extension->register();
                $registered_extensions[] = $Extension;
            }
            $this->addToRegistry( $Extension );
        }
        return $registered_extensions;
    }
    
    public function deregister(array $extension_classes ): array
    {
        $deregistered_extensions = [];
        foreach ( $extension_classes as $extension_class ) {
            $Extension = $this->getExtensionInstance( $extension_class );
            if ( $Extension->isRegistered() ) {
                $Extension->deregister();
                $deregistered_extensions[] = $Extension;
            }
            $this->removeFromRegistry( $Extension );
        }
        return $deregistered_extensions;
    }

    function get(string $identifier)
    {
        return $this->extensions[$identifier] ?? false;
    }


    protected function getExtensionInstance($extension_class)
    {
        $Extension = $this->Container->get( $extension_class );
        if ( !( $Extension instanceof Extension ) )
            throw new \InvalidArgumentException('Not a valid Extension class: ' . $extension_class );
        return $Extension;
    }
    
    protected function addToRegistry( Extension $Extension )
    {
        $type = $Extension->getType();
        $class = get_class( $Extension );
        $this->extensions[$type][$class] = $Extension;
    }
    
    protected function removeFromRegistry( Extension $Extension )
    {
        $type = $Extension->getType();
        $class = get_class( $Extension );
        if ( isset( $this->extensions[$type][$class] ) )
            unset( $this->extensions[$type][$class] );
    }
    
}