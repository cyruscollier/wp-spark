<?php

namespace Spark\Support;

interface View
{
    function prepare( $arguments );
    
    function render();
    
    function cleanup();
}