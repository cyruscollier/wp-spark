<?php

namespace Spark\Query;

use Spark\Support\Query\SubQuery as SubQueryInterface;

/**
 * Base class for building query parameter sets for WP_Query::set()
 * Child classes built based on current WP_Query API
 * 
 * @author cyruscollier
 *
 */
abstract class SubQuery implements SubQueryInterface
{

    /**
     * Holds stack of query clauses
     * @var array
     */
    private $query = [];

    private $relation = 'AND';

    public function __construct($relation = 'AND')
    {
        $this->setRelation($relation);
    }

    public function setRelation($relation = 'AND')
    {
        $this->relation = in_array($relation, ['OR', 'AND']) ? $relation : 'AND';
    }

    /**
     * @param SubQueryInterface $Subquery
     * @return static
     */
    public function addSubQuery(SubQueryInterface $Subquery)
    {
        if (! $Subquery instanceof static) {
            throw new \InvalidArgumentException('SubQuery subclass mismatch for sub-query');
        }
        return $this->addClause($Subquery->build(false));
    }

    public function build($filtered = true): array
    {
        $query = $this->query;
        if ($filtered) {
            $query = array_filter($query, [$this, 'hasClauseValue']);
        }
        //if only one subquery, promote to base query
        if (count($query) == 1 && $this->isBuiltSubQuery($query[0])) {
            $query = $query[0];
        }
        //add relation for multiple
        if (count($query) > 1 && !isset($query['relation'])) {
            $query['relation'] = $this->relation;
        }
        return $query;
    }
    
    /**
     * Adds clause to stack, used with public fluent wrapper methods
     * 
     * @param array $clause
     * @return $this
     */
    protected function addClause( array $clause )
    {
        $this->query[] = $clause;
        return $this;
    }

    protected function hasClauseValue( $clause )
    {
        if ($this->isBuiltSubQuery($clause)) {
            return true;
        }
        $value = $this->getClauseValue( $clause );
        if ( is_array( $value ) ) $value = array_filter( $value );
        return $value !== '';
    }

    protected function isBuiltSubQuery($clause)
    {
        return !empty($clause['relation']);
    }
    
    /**
     * Gets value inside of clause
     * 
     * @param array $clause
     * @return mixed
     */
    abstract protected function getClauseValue( array $clause );
    
    
}