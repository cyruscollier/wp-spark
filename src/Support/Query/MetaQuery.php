<?php

namespace Spark\Support\Query;

/**
 * Base class for building query parameter sets for WP_Query::set()
 * Child classes built based on current WP_Query API
 * 
 * @author cyruscollier
 *
 */
interface MetaQuery extends SubQuery
{
    function addRange( $key, $lower_value, $upper_value );
}