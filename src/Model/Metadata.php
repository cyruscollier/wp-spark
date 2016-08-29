<?php 

namespace Spark\Model;

/**
 * Defines properties of metadata
 * 
 * @author cyruscollier
 *
 */
interface Metadata
{
    /**
     * @return string
     */
    public function getType();
    
    /**
     * @return string
     */
    public function getKey();
    
    /**
     * @return mixed
     */
    public function getValue();
    
    /**
     * @param Metadata $metadata
     * @return Metadata
     */
    public function update( Metadata $metadata );
    
    /**
     * @return MetadataCollection
     */
    public function toCollection();
    
    /**
     * @return boolean
     */
    public function isCollection();
    
    public function __toString();
    
}