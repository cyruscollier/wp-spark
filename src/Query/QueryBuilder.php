<?php

namespace Spark\Query;

use Spark\Support\Query\SubQuery;

abstract class QueryBuilder implements \Spark\Support\Query\QueryBuilder
{
    protected $parameters = [];

    public function reset() {
        $this->parameters = [];
        return $this;
    }

    public function one()
    {
        return $this->limit(1);
    }

    public function where($params)
    {
        $this->parameters = array_merge($this->parameters, $params);
        return $this;
    }

    /**
     * Set order and order by parameters (SQL style)
     *
     * @param string|array $order_bys
     * @return $this
     */
    public function orderBy( $order_bys )
    {
        if ( !isset( $this->parameters['orderby'] ) ) $this->parameters['orderby'] = [];
        if ( !isset( $this->parameters['order'] ) ) $this->parameters['order'] = [];
        if ( !is_array( $order_bys ) ) $order_bys = explode( ',', $order_bys );
        foreach ( $order_bys as $order_by ) {
            $parts = explode( ' ', trim( $order_by ) );
            $this->parameters['orderby'][] = $parts[0];
            $this->parameters['order'][] = isset( $parts[1] ) ? $parts[1] : 'DESC';
        }
        return $this;
    }

    /**
     * Offset found records
     *
     * @param int $offset
     * @return $this
     */
    public function offset( $offset )
    {
        $this->parameters['offset'] = (int) $offset;
        return $this;
    }

    /**
     * Add structured subquery object
     *
     * @param SubQuery $SubQuery
     *
     * @return $this
     */
    public function withSubQuery(SubQuery $SubQuery)
    {
        $key = $SubQuery->getQueryKey();
        $this->parameters[$key] = $SubQuery->build();
        return $this;
    }

    public function build(): array
    {
        return $this->parameters;
    }
}