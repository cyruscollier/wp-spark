<?php 

namespace Spark\Support;

use Spark\Support\ImmutableRepository;

interface Repository extends ImmutableRepository
{
    public function add($object);

    public function remove($object);
}