<?php

namespace Spark\Model;

use Spark\Support\Collection;

/**
 * Iterator for set of Model instances
 * 
 * @author cyruscollier
 *
 */
class ModelCollection implements Collection
{
    /**
     * Array of Model instances
     * 
     * @var Model[]
     */
    protected $items = [];
    
    /**
     * Bound class for all instances inside collection
     * 
     * @var string
     */
    protected $model_class;
    
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
        if ( empty( $this->items ) ) {
            $this->model_class = get_class( $Object );
        }
        $this->checkValidModel( $Object );
        $this->items[] = $Object;
        return $this;
    }
    

    /**
     * 
     * @param Model $Object
     * @return $this
     */
    public function remove( Model $Object )
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
    public function offsetSet( $offset, $value )
    {
        if ( !( $value instanceof Model ) )
            throw new \InvalidArgumentException( 'ModelCollection must only contain Model instances' );
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
     * Model instance count in collection
     * 
     * @param int $mode
     * @return int
     */
    public function count($mode = null) {
        return count( $this->items );
    }
    
    protected function checkValidModel( Model $model )
    {
        if ( !( $model instanceof $this->model_class ) ) {
            throw new \InvalidArgumentException(
                'ModelCollection items must all be the same Model class'
            );
        }
    }
    
}