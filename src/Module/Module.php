<?php

namespace Spark\Module;

use Psr\Container\ContainerInterface;
use Spark\Support\Extension\Extension;
use Spark\Support\Extension\ExtensionRegistry;
use DI\Container;
use Spark\Model\Entity;
use Spark\Support\Entity\EntityRegistry;

abstract class Module
{
    /**
     * @var Container
     */
    protected $Container;
    
    /**
     * @var ExtensionRegistry
     */
    protected $ExtensionRegistry;

    /**
     * @var EntityRegistry
     */
    protected $EntityRegistry;
    
    protected $load_action;

    /**
     * @var Extension[]
     */
    protected $extensions = [];

    /**
     * @var Entity[]
     */
    protected $entities = [];

    /**
     * Module constructor.
     * @param ContainerInterface|null $Container
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __construct(ContainerInterface $Container = null)
    {
        $this->Container = $Container ?: spark();
        $this->ExtensionRegistry = $this->Container->get( ExtensionRegistry::class );
        $this->EntityRegistry = $this->Container->get( EntityRegistry::class );
        add_action( $this->load_action, [$this, 'registerExtensions'], 1 );
        add_action( $this->load_action, [$this, 'registerEntities'], 1 );
        add_action( $this->load_action, [$this, 'load'], 10 );
        add_action( 'init', [$this, 'init'], 10 );
    }
    
    public function registerExtensions()
    {
        $this->ExtensionRegistry->register( $this->extensions );
    }

    public function registerEntities()
    {
        $this->EntityRegistry->register( $this->entities );
    }
    
    public abstract function load();
    
    public abstract function init();
    
}