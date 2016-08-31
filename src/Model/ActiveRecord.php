<?php 

namespace Spark\Model;

use Spark\Query\QueryBuilder\PostTypeQueryBuilder;
use Spark\Query\SubQuery;

/**
 * Use in Model classes if using active record pattern
 * 
 * @author Cyrus
 * 
 * @method static QueryBuilder reset()
 * @method static QueryBuilder findAll()
 * @method static QueryBuilder findOne()
 * @method static QueryBuilder where(array $params)
 * @method static QueryBuilder orderBy(string $order_by)
 * @method static QueryBuilder limit(int $limit)
 * @method static QueryBuilder page(int $page)
 * @method static QueryBuilder offset(int $offset)
 * @method static QueryBuilder withQuery(SubQuery $RelatedQuery)
 * @method static self getOne(array $params)
 * @method static self|ModelCollection get(mixed $id)
 * @method static ModelCollection getIterator()
 * @method static array getParameters()
 * 
 *
 */
trait ActiveRecord {
    
    public function query()
    {
        if ( $this instanceof PostType )
            return new PostTypeQueryBuilder( get_class( $this ) );
        return $this->getDefaultQueryBuilder();
    }
    
    public function __call( $method, $arguments )
    {
        return call_user_func_array( [$this->query(), $method], $arguments );
    }
    
    public static function __callStatic( $method, $arguments )
    {
        return call_user_func_array( [new static, $method], $arguments );
    }
    
    protected function getDefaultQueryBuilder()
    {
        throw new \RuntimeException( 'Active Record trait used on invalid class' );
    }
}