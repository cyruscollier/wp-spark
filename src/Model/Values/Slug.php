<?php

namespace Spark\Model\Values;

class Slug
{
    protected $slug;
    
    public function __construct( $name )
    {
        $this->slug = sanitize_title( $name );
    }
    
    public function getSlug()
    {
        return $this->slug;
    }
    
    public function __toString()
    {
        return $this->getSlug();
    }
    
}