<?php

namespace Spark\Support;

/**
 * Basic collection interface
 * 
 * @author cyruscollier
 *
 */
interface Collection extends \ArrayAccess, \IteratorAggregate, \Countable {

    function add($object);

    function remove($object);
}