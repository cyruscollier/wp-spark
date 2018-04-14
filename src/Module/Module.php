<?php

namespace Spark\Module;

use Spark\Extension\ExtensionRegistry;
use DI\Container;

abstract class Module
{
    /**
     * @var Container
     */
    protected $Container;
    
    /**
     * @var ExtensionRegistry
     */
    protected $Extensions;
    
    protected $load_action;
    
    protected $extensions = [];

    /**
     * Module constructor.
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __construct()
    {
        $this->Container = spark();
        $this->Extensions = $this->Container->get( ExtensionRegistry::class );
        add_action( $this->load_action, [$this, 'registerExtensions'], 1 );
        add_action( $this->load_action, [$this, 'load'] );
        add_action( 'init', [$this, 'init'] );
    }
    
    public function registerExtensions()
    {
        $this->Extensions->register( $this->extensions );
    }
    
    public abstract function load();
    
    public abstract function init();
    
}