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

    public static function published()
    {
        return new static(static::STATUS_PUBLISH);
    }

    public static function future()
    {
        return new static(static::STATUS_FUTURE);
    }

    public static function draft()
    {
        return new static(static::STATUS_DRAFT);
    }

    public static function pending()
    {
        return new static(static::STATUS_PENDING);
    }

    public static function private()
    {
        return new static(static::STATUS_PRIVATE);
    }

    public static function trashed()
    {
        return new static(static::STATUS_TRASH);
    }
    
    public function isPublished() {
        return $this->value == self::STATUS_PUBLISH;
    }
    
    public function isFuture() {
        return $this->value == self::STATUS_FUTURE;
    }
    
    public function isDraft() {
        return $this->value == self::STATUS_DRAFT;
    }
    
    public function isPending() {
        return $this->value == self::STATUS_PENDING;
    }
    
    public function isPrivate() {
        return $this->value == self::STATUS_PRIVATE;
    }
    public function isTrashed() {
        return $this->value == self::STATUS_TRASH;
    }
    
    public static function getAllStatuses()
    {
        $core_statuses = isset( $GLOBALS['wp_post_statuses'] ) ? $GLOBALS['wp_post_statuses'] : [];
        return array_merge( self::$core_statuses, array_keys( $core_statuses ) );
    }
}