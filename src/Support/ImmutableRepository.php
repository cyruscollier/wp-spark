<?php 

namespace Spark\Support\Repository;

interface ImmutableRepository
{
    public function findOne( array $params = [] );

    public function find( array $params = [] );
}