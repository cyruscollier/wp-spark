<?php 

namespace Spark\Model;

use Spark\Model\Values;
use WP_Post, WP_User;
use Spark\Model\Values\PostMetaField;

/**
 * Base class for all post types
 * 
 * @author cyruscollier
 *
 */
abstract class PostType extends ModelWithMetadata
{
    
    /**
     * Post type must be set in sub classes
     * 
     * @var string
     */
    const POST_TYPE = null;
    
    /**
     * Post ID
     * 
     * @var int
     */
    protected $id;
    
    /**
     * Post parent ID
     * 
     * @var int
     */
    protected $parent_id;
    
    /**
     * Post author's user ID
     * @var int
     */
    protected $author_id;
    
    /**
     * Full author WP_User object
     * 
     * @var WP_User
     */
    protected $author;
    
    /**
     * Post publish date (and gmt)
     * 
     * @var Values\PostDate
     */
    protected $published_date;
    
    /**
     * Post modified date (and gmt)
     * 
     * @var Values\PostModifiedDate
     */
    protected $modified_date;
    
    /**
     * Post title
     * 
     * @var Values\PostTitle
     */
    protected $title;
    
    /**
     * Post slug
     * 
     * @var string
     */
    protected $slug;
    
    /**
     * Post content
     * 
     * @var Values\PostContent
     */
    protected $content;
    
    /**
     * Post excerpt
     * 
     * @var Values\PostExcerpt
     */
    protected $excerpt;
    
    /**
     * Post status
     * 
     * @var Values\PostStatus
     */
    protected $status;
    
    /**
     * Original WP_Post instance, hidden
     * 
     * @var WP_Post
     */
    protected $_wp_post;
    
    /**
     * 
     * @param WP_Post $post
     * @param Metadata[] $all_metadata
     * @throws \InvalidArgumentException
     */
    static function createFromPost( WP_Post $post, $all_metadata = [] )
    {
        if ( $post->post_type != static::POST_TYPE )
            throw new \InvalidArgumentException( 'Post type mismatch.' );
        $Post = new static;
        $Post->id = (int) $post->ID;
        $Post->parent_id = (int) $post->post_parent;
        $Post->author_id = (int) $post->post_author;
        $Post->title = new Values\PostTitle( $post->post_title );
        $Post->content = new Values\PostContent( $post->post_content );
        $Post->excerpt = new Values\PostExcerpt( get_the_excerpt( $post ) );
        $Post->status = new Values\PostStatus( $post->post_status );
        $Post->published_date = new Values\PostDate( $post->post_date, $post->post_date_gmt );
        $Post->modified_date = new Values\PostModifiedDate( $post->post_modified, $post->post_modified_gmt ); 
        $Post->slug = $post->post_name;
        $Post->_wp_post = $post;
        foreach ( $all_metadata as $metadata ) {
            $Post->setMetadata( $metadata );
        }
        return $Post;
    }
    
    protected function setTitle( Values\PostTitle $title )
    {
        $this->title = $title;
    }
    
    protected function setContent( Values\PostContent $content )
    {
        $this->content = $content;
    }
    
    protected function setExcerpt( Values\PostExcerpt $excerpt )
    {
        $this->excerpt = $excerpt;
    }
    
    protected function setStatus( Values\PostStatus $status )
    {
        $this->status = $status;
    }
    
    protected function setPublishedDate( Values\PostDate $published_date )
    {
        $this->published_date = $published_date;
    }
    
    protected function setModifiedDate( Values\PostModifiedDate $modified_date )
    {
        $this->modified_date = $modified_date;
    }
    
    public function __get( $name )
    {
        if ( $value = parent::__get( $name ) );
            return $value;
        if ( property_exists( $this->_wp_post, $name ) )
            return $this->_wp_post->$name;
    }
    
    /**
     * @param string $key
     * @param mixed $value
     * @return MetadataField
     */
    public function createMetadataField( $key, $value )
    {
        return new PostMetaField( $key, $value );
    }
        
}