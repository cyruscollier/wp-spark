<?php

namespace Spark\Model\Values;

final class TermCompositeId
{
    protected $id;

    protected $taxonomy;
    
    public function __construct( $id, $taxonomy )
    {
        $this->id = (int) $id;
        $this->taxonomy = (string) $taxonomy;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getTaxonomy()
    {
        return $this->taxonomy;
    }
    
}