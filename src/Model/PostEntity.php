<?php

namespace Spark\Model;

use Spark\Media\ImageFile;
use Spark\Media\MediaFile;
use Spark\Model\Values;
use Spark\Model\Values\PostMetaField;
use Spark\Support\Collection;

/**
 * Base class for all post types
 *
 * @author cyruscollier
 *
 * @property int $id
 * @property int $parent_id
 * @property int $author_id;
 * @property Values\PostTitle $title
 * @property Values\PostContent $content
 * @property Values\PostExcerpt $excerpt
 * @property Values\PostStatus $status
 * @property Values\PostDate $published_date
 * @property Values\PostModifiedDate $modified_date
 * @property Values\Slug $slug
 * @property \WP_Post $wp_post
 * @property Collection $terms
 * @property int $featured_image_id
 * @property ImageFile $featured_image
 *
 */
class PostEntity extends EntityWithMetadata
{

    /**
     * Post type must be set in sub classes
     *
     * @var string
     */
    const POST_TYPE = null;

    /**
     * Associated taxonomies, must have registered TermEntity entity class
     *
     * @var array
     */
    const TAXONOMIES = [];

    protected static $metadata_type = PostMetaField::class;

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
     * Original WP_Post instance
     *
     * @var \WP_Post
     */
    protected $wp_post;

    protected $_terms_reference;

    /**
     * @var Collection
     */
    protected $terms;

    protected $_featured_image_reference;

    /**
     * @var MediaFile
     */
    protected $featured_image;

    public static function getRegistryKey()
    {
        return static::POST_TYPE ?: false;
    }

    public function setTitle( Values\PostTitle $title )
    {
        $this->title = $title;
    }

    public function setContent( Values\PostContent $content )
    {
        $this->content = $content;
    }

    public function setExcerpt( Values\PostExcerpt $excerpt )
    {
        $this->excerpt = $excerpt;
    }

    public function setStatus( Values\PostStatus $status )
    {
        $this->status = $status;
    }

    public function setPublishedDate( Values\PostDate $published_date )
    {
        $this->published_date = $published_date;
    }

    public function setModifiedDate( Values\PostModifiedDate $modified_date )
    {
        $this->modified_date = $modified_date;
    }

    public function setSlug( Values\Slug $slug )
    {
        $this->slug = $slug;
    }

    public function setTermsReference(callable $callback)
    {
        $this->_terms_reference = $callback;
    }

    public function getTerms(): Collection
    {
        if (!isset($this->terms) && is_callable($this->_terms_reference)) {
            $this->terms = call_user_func($this->_terms_reference, $this);
            unset($this->_terms_reference);
        }
        return $this->terms;
    }

    public function getTermsForTaxonomy($taxonomy): Collection
    {
        return $this->getTerms()->filter(function(TermEntity $t) use ($taxonomy) { return $t->getTaxonomy() == $taxonomy; });
    }

    public function getFeaturedImageId()
    {
        return $this->_metadata['_thumbnail_id'] ?? false;
    }

    public function setFeaturedImageReference(callable $callback)
    {
        $this->_featured_image_reference = $callback;
    }

    public function getFeaturedImage(): ImageFile
    {
        if (!isset($this->featured_image) && is_callable($this->_featured_image_reference)) {
            $this->featured_image = call_user_func($this->_featured_image_reference, $this);
            unset($this->_featured_image_reference);
        }
        return $this->featured_image;
    }

    public function getPostType()
    {
        return static::POST_TYPE ?: $this->wp_post->post_type ?? false;
    }

    public function __get( $name )
    {
        if ( $value = parent::__get( $name ) )
            return $value;
        if ( isset($this->wp_post) && property_exists( $this->wp_post, $name ) )
            return $this->wp_post->$name;
        return null;
    }

}
