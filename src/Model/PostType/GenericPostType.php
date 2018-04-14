<?php 

namespace Spark\Model\PostType;

use Spark\Model\PostType;

final class GenericPostType extends PostType
{
    public static function getRegistryKey()
    {
        return false;
    }
}