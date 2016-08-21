<?php

namespace Spark\Model;

class Collection implements \ArrayAccess, \IteratorAggregate
{
    protected $items = [];
    
    public function __construct( array $items )
    {
        foreach ( $items as $item ) {
            $this->add( $item );
        }
    }
    
    public function add( Model $Object )
    {
        $this->items[] = $Object;
        return $this;
    }
    
    /**
     * @param offset
     */
    public function offsetExists( $offset )
    {
        return isset( $this->items[$offset] );
    }
    
    /**
     * @param offset
     */
    public function offsetGet( $offset ) 
    {
        return $this->items[$offset];
    }
    
    /**
     * @param offset
     * @param value
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
     * @param offset
     */
    public function offsetUnset( $offset ) {
        unset( $this->items[$offset] );
    }  
    
    
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }
    
}