<?php

namespace Spark\Query;
use Spark\Model\PostType\Post;
use Spark\Model\Values\PostDate;

/**
 * Builds query clauses for 'date_query' variable of WP_Query
 *
 * @author cyruscollier
 *
 */
class DateQuery extends SubQuery
{
    /**
     * Adds clause
     *
     * @param string|PostDate $date
     * @param string|array $values
     * @param string $compare
     * @param string $column
     * @return $this
     */
    public function add( $date, $values = ['year', 'month', 'day'], $compare = '=', $column = 'post_date' )
    {
        if ( !is_array( $values ) ) $values = [$values];
        if (! $date instanceof PostDate) {
            $date = new PostDate($date);
        }
        $date_values = [];
        foreach ($values as $value) {
            if ($value == 'week') $value = 'weekOfYear';
            $date_values[$value] = $date->{$value};
        }
        return $this->addClause(array_merge($date_values, compact( 'compare', 'column' )));
    }

    /**
     * @param string|PostDate $date
     * @param bool $inclusive
     * @param string $compare
     * @param string $column
     * @return $this
     */
    public function addBefore($date, $inclusive = false, $compare = '=', $column = 'post_date')
    {
        $before = $date->toDateTimeString();
        return $this->addClause( compact( 'before', 'inclusive', 'compare', 'column' ) );
    }

    /**
     * @param string|PostDate $date
     * @param bool $inclusive
     * @param string $compare
     * @param string $column
     * @return $this
     */
    public function addAfter($date, $inclusive = false, $compare = '=', $column = 'post_date')
    {
        $after = $date->toDateTimeString();
        return $this->addClause( compact( 'after', 'inclusive', 'compare', 'column' ) );
    }
    
    /**
     * Name of query key to user for this subquery
     *
     * @return string
     */
    function getQueryKey()
    {
        return 'date_query';
    }
    
    /**
     * Gets value inside of clause
     *
     * @param array $clause
     * @return mixed
     */
    protected function getClauseValue( array $clause )
    {
        return $clause['date'];
    }
    
}