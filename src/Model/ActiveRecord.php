<?php 

namespace Spark\Model;

use Spark\Query\QueryBuilder\PostTypeQueryBuilder;
use Spark\Query\SubQuery;
use Spark\Query\QueryBuilder;
use DI\FactoryInterface;

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
    
    /**
     * @param FactoryInterface $Factory|null
     * 
     * @return QueryBuilder
     */
    public function query( FactoryInterface $Factory = null )
    {
        if ( !$Factory ) $Factory = spark();
        foreach ( $this->getQueryBuilderMap() as $model_class => $query_builder_class ) {
            if ( $this instanceof $model_class )
                return $Factory->make( 
                    $query_builder_class, 
                    ['model_class' => get_class( $this )] 
                );
        }
        throw new \RuntimeException( 'Active Record trait used on class without a QueryBuilder' );
    }
    
    public function __call( $method, $arguments )
    {
        return call_user_func_array( [$this->query(), $method], $arguments );
    }
    
    public static function __callStatic( $method, $arguments )
    {
        return call_user_func_array( [new static, $method], $arguments );
    }
    
    protected function getQueryBuilderMap()
    {
        return [
            PostType::class => PostTypeQueryBuilder::class
        ];
    }
}