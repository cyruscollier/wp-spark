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
        $model_class = get_class( $this );
        switch ( get_class( $this ) ) {
            case PostType::class:
                return new PostTypeQueryBuilder( $model_class );
                break;
            default:
                throw new \RuntimeException( 'Active Record trait used on invalid class' );
                break;
        }
    }
    
    public static function __callStatic( $method, $arguments )
    {
        $model = new static;
        $QueryBuilder = $model->query();
        if ( method_exists( $QueryBuilder, $method ) ) {
            return call_user_func_array( [$QueryBuilder, $method], $arguments );
        }
    }
}