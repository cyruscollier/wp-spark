<?php 

namespace Spark\Support;

interface ImmutableRepository
{
    public function findOne(array $params = []);

    public function find(array $params = []);

    public function findAll();
}