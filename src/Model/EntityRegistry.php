<?php 

namespace Spark\Model;

use Interop\Container\ContainerInterface;
use Spark\Support\Registry;

final class EntityRegistry implements Registry
{
    
    /**
     * @var ContainerInterface
     */
    protected $Container;
    
    /**
     * Complete reference of registered entities
     * @var array
     */
    protected $entities = [];
    
    public function __construct( ContainerInterface $Container )
    {
        $this->Container = $Container;
    }
    
    public function register(array $entity_classes ): array
    {
        $registered_entities = [];
        foreach ( $registered_entities as $entity_class ) {
            $Entity = $this->getEntityInstance( $entity_class );
            if (!isset($this->entities[$Entity->getRegistryKey()])) {
                $this->entities[$Entity->getRegistryKey()] = $Entity;
                $registered_entities[] = $Entity;
            }
        }
        return $registered_entities;
    }
    
    public function deregister(array $entity_classes ): array
    {
        $deregistered_entities = [];
        foreach ( $entity_classes as $entity_class ) {
            $Entity = $this->getEntityInstance( $entity_class );
            if (isset($this->entities[$Entity->getRegistryKey()])) {
                unset($this->entities[$Entity->getRegistryKey()]);
                $deregistered_entities[] = $Entity;
            }
        }
        return $deregistered_entities;
    }

    function get(string $identifier)
    {
        return $this->entities[$identifier] ?? false;
    }


    /**
     * @param $entity_class
     * @return Entity
     */
    protected function getEntityInstance($entity_class)
    {
        $Entity = new $entity_class;
        if (! $Entity instanceof Entity)
            throw new \InvalidArgumentException('Not a valid Entity class: ' . $entity_class );
        return $Entity;
    }
    
}