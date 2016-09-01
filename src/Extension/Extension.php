<?php

namespace Spark\Extension;

/**
 * Defines an extension for WordPress that can be registered and unregistered
 * 
 * @author cyruscollier
 *
 */
interface Extension
{
    public function getType();
    
    public function register();
    
    public function isRegistered();
    
    public function deregister();
}