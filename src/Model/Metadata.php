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
    
    public function __toString();
    
}