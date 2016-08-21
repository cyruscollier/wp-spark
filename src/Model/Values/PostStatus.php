<?php 

namespace Spark\Model\Values;

class PostStatus extends FilteredValue {
    
    const STATUS_PUBLISH = 'publish';
    const STATUS_FUTURE = 'future';
    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';
    const STATUS_PRIVATE = 'private';
    const STATUS_TRASH = 'trash';
    const STATUS_AUTO_DRAFT = 'auto-draft';
    const STATUS_INHERIT = 'inherit';
    
    static $core_statuses = [
        self::STATUS_PUBLISH, self::STATUS_FUTURE,
        self::STATUS_DRAFT, self::STATUS_PENDING,
        self::STATUS_PRIVATE, self::STATUS_TRASH,
        self::STATUS_AUTO_DRAFT, self::STATUS_INHERIT,
    ];
    
    /**
     * Name used for filter
     *
     * @var string
     */
    protected $filter = 'get_post_status';
    
    /**
     * Constructor
     * 
     * @param string $status
     */
    function __construct( $status )
    {
        if ( !in_array( $status, self::getAllStatuses() ) ) {
            throw new \InvalidArgumentException( 'Invalid post status: ' . $status );
        }
        parent::__construct( $status );
    }
    
    function isPublished() {
        return $this->value == self::STATUS_PUBLISH;
    }
    
    function isFuture() {
        return $this->value == self::STATUS_FUTURE;
    }
    
    function isDraft() {
        return $this->value == self::STATUS_DRAFT;
    }
    
    function isPending() {
        return $this->value == self::STATUS_PENDING;
    }
    
    function isPrivate() {
        return $this->value == self::STATUS_PRIVATE;
    }
    
    function isTrashed() {
        return $this->value == self::STATUS_TRASH;
    }
    
    static function getAllStatuses()
    {
        global $wp_post_statuses;
        return array_merge( self::$core_statuses, array_keys( $wp_post_statuses ) );
    }
}