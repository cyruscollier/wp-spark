<?php

namespace Spark\Model;

use Spark\Support\Collection;

/**
 * Iterator for set of Model Entity instances
 * 
 * @author cyruscollier
 *
 */
final class EntityCollection implements Collection
{
    /**
     * Array of Entity instances
     * 
     * @var Entity[]
     */
    protected $items = [];
    
    /**
     * Bound class for all instances inside collection
     * 
     * @var string
     */
    protected $model_class;
    
    /**
     * Constructor takes array of Entity instances
     * 
     * @param array $items
     */
    public function __construct( array $items = [] )
    {
        foreach ( $items as $item ) {
            $this->add( $item );
        }
    }
    
    /**
     * Append an Entity instance to the collection
     * 
     * @param Entity $Object
     * @return $this
     */
    public function add( Entity $Object )
    {
        if ( empty( $this->items ) ) {
            $this->model_class = get_class( $Object );
        }
        $this->checkValidEntity( $Object );
        $this->items[] = $Object;
        return $this;
    }
    

    /**
     * 
     * @param Entity $Object
     * @return $this
     */
    public function remove( Entity $Object )
    {
        foreach ( $this->items as $index => $item ) {
            if ( $item === $Object ) {
                $this->offsetUnset( $index );
            }
        }
        return $this;
    }
    
    /**
     * ArrayAccess isset($array[$i])
     * 
     * @param int $offest
     * @return boolean
     */
    public function offsetExists( $offset )
    {
        return isset( $this->items[$offset] );
    }
    
    /**
     * ArrayAccess $array[$i]
     * 
     * @param int $offset
     * @return Entity
     */
    public function offsetGet( $offset ) 
    {
        return $this->items[$offset];
    }
    
    /**
     * ArrayAccess $array[$i] = ..., $array[] = ...
     * 
     * @param int|null $offset
     * @param mixed $value
     */
    public function offsetSet( $offset, $value )
    {
        if ( !( $value instanceof Entity ) )
            throw new \InvalidArgumentException( 'EntityCollection must only contain Entity instances' );
        if ( is_null( $offset ) ) {
            $this->add( $value );
        } else {
            $this->items[$offset] = $value;
        }
    }
    
    /**
     * ArrayAccess unset($array[$i])
     * 
     * @param int $offset
     */
    public function offsetUnset( $offset ) {
        unset( $this->items[$offset] );
    }  
    
    /**
     * Iterator for collection
     * 
     * {@inheritDoc}
     * @see IteratorAggregate::getIterator()
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->items );
    }
    
    /**
     * Entity instance count in collection
     * 
     * @param int $mode
     * @return int
     */
    public function count($mode = null) {
        return count( $this->items );
    }
    
    protected function checkValidEntity( Entity $model )
    {
        if ( !( $model instanceof $this->model_class ) ) {
            throw new \InvalidArgumentException(
                'EntityCollection items must all be the same Entity class'
            );
        }
    }
    
}