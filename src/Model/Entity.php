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
    protected static $unique_key = 'id';

    public function __construct($id = null)
    {
        $this->{$this->getIdProperty()} = $id;
    }

    public abstract static function getRegistryKey();
    
    /**
     * Return unique identifier for entity, used in EntityCollection
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
        return static::$unique_key;
    }
    
    /**
     * Check isset() on non-hidden property
     * 
     * @param string $name
     * @return bool
     */
    public function __isset( $name )
    {
        if ( property_exists( $this, $name ) && !$this->isHiddenProperty( $name ) ) {
            return isset( $this->$name );
        }
        return false;
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
     * @return bool
     */
    public function __set( $name, $value )
    {
        if ( $setter = $this->getMethodFromProperty( $name, 'set' ) ) {
            call_user_func( [$this, $setter], $value );
            return null;
        }
        if ( 
            property_exists( $this, $name ) && 
            !( $this->isHiddenProperty( $name ) || $name == $this->getIdProperty() ) 
        ) {
            $this->$name = $value;
            return null;
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
     * @return bool
     */
    protected function isHiddenProperty( $name )
    {
        return 0 === strpos( $name, '_' );
    }
    
}