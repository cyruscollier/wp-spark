<?php 

namespace Spark\Model;

use Spark\Support\Registry;

final class EntityRegistry implements Registry
{
    
    /**
     * Complete reference of registered entities
     * @var array
     */
    protected $entities = [];
    
    public function register(array $entity_classes ): array
    {
        $registered_entities = [];
        foreach ( $registered_entities as $entity_class ) {
            $this->checkType( $entity_class );
            $key = $entity_class::getRegistryKey();
            if (!isset($this->entities[$key])) {
                $this->entities[$key] = $entity_class;
                $registered_entities[] = $entity_class;
            }
        }
        return $registered_entities;
    }
    
    public function deregister(array $entity_classes ): array
    {
        $deregistered_entities = [];
        foreach ( $entity_classes as $entity_class ) {
            $this->checkType( $entity_class );
            $key = $entity_class::getRegistryKey();
            if (isset($this->entities[$key])) {
                unset($this->entities[$key]);
                $deregistered_entities[] = $entity_class;
            }
        }
        return $deregistered_entities;
    }

    public function get(string $identifier)
    {
        return $this->entities[$identifier] ?? false;
    }


    /**
     * @param $entity_class
     */
    protected function checkType($entity_class)
    {
        if (!is_a($entity_class, Entity::class, true))
            throw new \InvalidArgumentException('Not a valid Entity class: ' . $entity_class );
    }
    
}