<?php

namespace Spark\Extension;

interface View
{
    function prepare();
    
    function render();
    
    function cleanup();
}