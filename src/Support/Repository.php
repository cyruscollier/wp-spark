<?php 

namespace Spark\Support\Repository;

interface Repository extends ImmutableRepository
{
    public function add($object);

    public function remove($object);
}