<?php

namespace Spark\Support;

/**
 * Basic collection interface
 * 
 * @author cyruscollier
 *
 */
class Collection extends \Tightenco\Collect\Support\Collection {

    public function add($object)
    {
        return $this->push($object);
    }

    public function remove($object)
    {
        $index = $this->search($object, true);
        if (false !== $index) {
            $this->offsetUnset($index);
            return true;
        }
        return false;
    }
}