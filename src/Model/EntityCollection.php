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

    protected $hash_map = [];
    
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
     * @param $object
     * @return $this
     */
    public function add( $object )
    {
        $this->checkValidEntity($object);
        $this->items[] = $object;
        $this->hash_map[$this->getEntityHash($object)] = count($this->items) - 1;
    }
    

    /**
     * @param $object
     */
    public function remove($object)
    {
        $this->checkValidEntity($object);
        $hash = $this->getEntityHash($object);
        $index = $this->hash_map[$hash] ?? false;
        if ($index) {
            $this->offsetUnset($index);
            unset($this->hash_map[$hash]);
        }
    }
    
    /**
     * ArrayAccess isset($array[$i])
     * 
     * @param int $offset
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
        $this->checkValidEntity($value);
        if ( !(is_int($offset) || is_null($offset)) )
            throw new \InvalidArgumentException( 'EntityCollection must use numeric keys' );
        if ( is_null( $offset ) ) {
            $this->add( $value );
        } else {
            if ($this->offsetExists($offset)) {
                $object = $this->offsetGet($offset);
                unset($this->hash_map[$this->getEntityHash($object)]);
            }
            $this->items[$offset] = $value;
            $this->hash_map[$this->getEntityHash($value)] = $offset;
        }
    }
    
    /**
     * ArrayAccess unset($array[$i])
     * 
     * @param int $offset
     */
    public function offsetUnset( $offset ) {
        $Object = $this->offsetGet($offset);
        unset($this->items[$offset]);
        unset($this->hash_map[$this->getEntityHash($Object)]);
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
    
    protected function checkValidEntity( $object )
    {
        if ( !( $object instanceof Entity ) ) {
            throw new \InvalidArgumentException(
                'EntityCollection must only contain Entity instances'
            );
        }
    }

    protected function getEntityHash( Entity $Object )
    {
        return md5($Object->getId());
    }
    
}