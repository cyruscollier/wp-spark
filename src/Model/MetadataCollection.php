<?php 

namespace Spark\Model;

use Spark\Support\Collection;
use Spark\Model\Values\MetadataField;

/**
 * Representation of multiple metadata fields of the same type and key
 * 
 * @author cyruscollier
 *
 */
class MetadataCollection implements Metadata, Collection
{
    
    /**
     * @var string
     */
    protected $type;
    
    /**
     * @var string
     */
    protected $key;
    
    /**
     * @var MetadataField[]
     */
    protected $fields = [];
        
    public function __construct( $fields = [] )
    {
        foreach ( $fields as $index => $field )
        {
            if ( !( $field instanceof MetadataField ) )
                throw new \InvalidArgumentException( 'MetadataCollection must contain MetadataField instances' );
            $this->add( $field );
        }
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function getKey()
    {
        return $this->key;
    }
    
    public function getValue()
    {
        return array_values( array_filter( $this->fields, [$this, 'isFieldSet'] ) );
    }
    
    public function update( Metadata $metadata )
    {
        foreach ( $metadata->toCollection() as $field ) {
            $this->add( $field );
        }
        return $this;
    }
    
    public function toCollection()
    {
        return $this;
    }

    public function isCollection()
    {
        return true;
    }
    
    public function __toString()
    {
        return implode( ',', array_map( 'strval', $this->fields ) );
    }
    
    public function add( MetadataField $field )
    {
        if ( empty( $this->fields ) ) {
            $this->type = $field->getType();
            $this->key = $field->getKey();
        }
        $this->checkValidField( $field );
            
        $index = $field->getIndex();
        $this->fields[$index] = isset( $this->fields[$index] ) ? 
            $this->fields[$index]->updateValue( $field->getValue() ) : 
            $field;
        return $this;
    }
    
    public function remove( MetadataField $field )
    {
        $this->checkValidField( $field );
        $index = $field->getIndex();
        if ( isset( $this->fields[$index] ) ) {
            $this->fields[$index] = $this->fields[$index]->updateValue( null );
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
        $values = array_values( $this->fields );
        return isset( $values[$offset] ) && $this->isFieldSet( $values[$offset] );
    }
    
    /**
     * ArrayAccess $array[$i]
     *
     * @param int $offset
     * @return Model
     */
    public function offsetGet( $offset )
    {
        $values = array_values( $this->fields );
        $field = $values[$offset];
        return $this->isFieldSet( $field ) ? $field : null;
    }
    
    /**
     * ArrayAccess $array[$i] = ..., $array[] = ...
     *
     * @param int|null $offset
     * @param mixed $value
     */
    public function offsetSet( $offset, $field )
    {
        $values = array_values( $this->fields );
        $this->checkValidField( $field );
        if ( isset( $values[$offset] ) )
            $values[$offset]->update( $field );
        else
            $this->add( $field );
    }
    
    /**
     * ArrayAccess unset($array[$i])
     *
     * @param int $offset
     */
    public function offsetUnset( $offset ) {
        $values = array_values( $this->fields );
        $this->remove( $values[$offset] );
    }
    
    /**
     * Iterator for collection
     *
     * {@inheritDoc}
     * @see IteratorAggregate::getIterator()
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->getValue() );
    }
    
    /**
     * MetadataField instance count in collection
     *
     * @param int $mode
     * @return int
     */
    public function count( $mode = null ) {
        return count( $this->getValue() );
    }
    
    protected function checkValidField( MetadataField $field )
    {
        if ( 
            $field->getType() != $this->type || 
            $field->getKey() != $this->key 
        ) {
            throw new \InvalidArgumentException( 
                'MetadataCollection fields must all be the same type and key' 
            );
        }
    }
    
    protected function isFieldSet( MetadataField $field )
    {
        return !is_null( $field->getValue() );
    }
    
}