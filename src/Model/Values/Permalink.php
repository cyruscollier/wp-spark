<?php

namespace Spark\Model\Values;

class Permalink
{
    protected $permalink;
    
    public function __construct( $permalink )
    {
        $this->permalink = $permalink;
    }
    
    public function __toString()
    {
        return $this->permalink;
    }
    
}