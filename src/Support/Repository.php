<?php 

namespace Spark\Support;

interface Repository extends ImmutableRepository
{
    public function add($object);

    public function remove($object);
}