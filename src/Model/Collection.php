<?php

namespace Spark\Model;

/**
 * Iterator for set of Model instances
 * 
 * @author cyruscollier
 *
 */
class Collection implements \ArrayAccess, \IteratorAggregate
{
    /**
     * Array of Model instances
     * 
     * @var Model[]
     */
    protected $items = [];
    
    /**
     * Constructor takes array of Model instances
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
     * Append a Model instance to the collection
     * 
     * @param Model $Object
     * @return $this
     */
    public function add( Model $Object )
    {
        $this->items[] = $Object;
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
     * @return Model
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
    public function offsetSet ( $offset, $value )
    {
        if ( !( $value instanceof Model ) )
            throw new \InvalidArgumentException( 'Model Collection must only contain Model instances' );
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
        return new ArrayIterator( $this->items );
    }
    
}