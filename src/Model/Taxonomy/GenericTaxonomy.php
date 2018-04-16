<?php 

namespace Spark\Model\Taxonomy;

use Spark\Model\Taxonomy;

final class GenericTaxonomy extends Taxonomy
{
    public static function getRegistryKey()
    {
        return false;
    }

    public function getTaxonomy()
    {
        return $this->wp_term->taxonomy;
    }
}