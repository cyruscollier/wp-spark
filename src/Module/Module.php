<?php

namespace Spark\Module;

use Spark\Extension\ExtensionManager;
use DI\Container;

abstract class Module
{
    /**
     * @var Container
     */
    protected $Container;
    
    /**
     * @var ExtensionManager
     */
    protected $ExtensionManager;
    
    protected $load_action;
    
    protected $extensions = [];
    
    public function __construct()
    {
        $this->Container = spark();
        $this->ExtensionManager = $this->Container->get( ExtensionManager::class );
        add_action( $this->load_action, [$this, 'registerExtensions'], 1 );
        add_action( $this->load_action, [$this, 'load'] );
        add_action( 'init', [$this, 'init'] );
    }
    
    public function registerExtensions()
    {
        $this->ExtensionManager->registerExtensions( $this->extensions );
    }
    
    public abstract function load();
    
    public abstract function init();
    
}