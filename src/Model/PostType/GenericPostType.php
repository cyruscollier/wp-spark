<?php 

namespace Spark\Model\PostType;

use Spark\Model\PostType;

final class GenericPostType extends PostType
{
    public static function getRegistryKey()
    {
        return false;
    }

    public function getPostType()
    {
        return $this->wp_post->post_type;
    }
}