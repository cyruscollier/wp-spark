<?php 

namespace Spark\Model;

/**
 * Base class for all models
 * 
 * @author cyruscollier
 *
 */
abstract class Entity
{
    protected $unique_key = 'id';
    
    /**
     * Return unique identifier for model, used in ModelCollection
     * 
     * @return string
     */
    public function getId()
    {
        return $this->{$this->getIdProperty()};
    }
    
    /**
     * Return property name used for model's unique identifier
     * 
     * @return string
     */
    protected function getIdProperty()
    {
        return $this->unique_key;
    }
    
    /**
     * Check isset() on non-hidden property
     * 
     * @param string $name
     */
    public function __isset( $name )
    {
        if ( property_exists( $this, $name ) && !$this->isHiddenProperty( $name ) ) {
            return isset( $this->$name );
        }
    }
    
    /**
     * Call getter method if exists otherwise return non-hidden property value
     * 
     * @param string $name
     * @return mixed
     */
    public function __get( $name )
    {
        if ( $getter = $this->getMethodFromProperty( $name, 'get' ) )
            return call_user_func( [$this, $getter] );
        if ( property_exists( $this, $name ) && !$this->isHiddenProperty( $name ) )
            return $this->$name;
    }
    
    /**
     * Call setter method if exists, otherwise set property to new value
     * 
     * @param string $name
     * @param mixed $value
     */
    public function __set( $name, $value )
    {
        if ( $setter = $this->getMethodFromProperty( $name, 'set' ) ) {
            call_user_func( [$this, $setter], $value );
        }
        if ( 
            property_exists( $this, $name ) && 
            !( $this->isHiddenProperty( $name ) || $name == $this->getIdProperty() ) 
        ) {
            $this->$name = $value;
        }
        return false;
    }
    
    /**
     * Matches a property name with a prefixed method name, converting snake_case to CamelCase
     * ex. getMethodFromProperty( 'post_title', 'get' ): 'getPostTitle'
     * 
     * @param string $property
     * @param string $prefix
     * @return boolean|string
     */
    protected function getMethodFromProperty( $property, $prefix )
    {
        $method = $prefix . spark_to_pascal_case( $property );
        return method_exists( $this, $method ) ? $method : false;
    }
    
    /**
     * "Hidden" properties begin with an underscore
     * 
     * @param string $name
     */
    protected function isHiddenProperty( $name )
    {
        return 0 === strpos( $name, '_' );
    }
    
}