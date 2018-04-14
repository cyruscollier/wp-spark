<?php

namespace Spark\Support\Extension;

/**
 * Defines an extension for WordPress that can be registered and unregistered
 * 
 * @author cyruscollier
 *
 */
interface Extension
{
    function getType();
    
    function register();
    
    function isRegistered();
    
    function deregister();
}