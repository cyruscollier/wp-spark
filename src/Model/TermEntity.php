<?php 

namespace Spark\Model;

use Spark\Model\Values;

/**
 * Base class for all taxonomies
 * 
 * @author cyruscollier
 *
 * @property int $id
 * @property int $parent_id
 * @property int $post_count;
 * @property Values\TermName $name
 * @property Values\TermDescription $description
 * @property Values\Slug $slug
 * @property \WP_Term $wp_term
 *
 */
class TermEntity extends EntityWithMetadata
{
    
    /**
     * TermEntity must be set in sub classes
     * 
     * @var string
     */
    const TAXONOMY = null;

    protected static $metadata_type = Values\TermMetaField::class;

    /**
     * Term ID
     *
     * @var int
     */
    protected $id;

    /**
     * Term's parent ID
     *
     * @var int
     */
    protected $parent_id;

    /**
     * Term's total post count
     *
     * @var int
     */
    protected $post_count;

    /**
     * Term Name
     *
     * @var Values\TermName
     */
    protected $name;

    /**
     * @var Values\TermDescription
     */
    protected $description;

    /**
     * @var Values\Slug
     */
    protected $slug;

    /**
     * Original WP_Term instance
     *
     * @var \WP_Term
     */
    protected $wp_term;

    public static function getRegistryKey()
    {
        return static::TAXONOMY ?: false;
    }

    public function setName( Values\TermName $name )
    {
        $this->name = $this->addCompositeId($name);
    }

    public function setDescription( Values\TermDescription $description )
    {
        $this->description = $this->addCompositeId($description);
    }

    public function setSlug( Values\Slug $slug )
    {
        $this->slug = $slug;
    }

    public function getTaxonomy()
    {
        return static::TAXONOMY ?: $this->wp_term->taxonomy ?? false;
    }

    public function __get( $name )
    {
        if ( $value = parent::__get( $name ) )
            return $value;
        if ( isset($this->wp_term) && property_exists( $this->wp_term, $name ) )
            return $this->wp_term->$name;
        return null;
    }

    protected function addCompositeId(Values\TermFilteredValue $object)
    {
        $composite_id = new Values\TermCompositeId($this->id, $this->getTaxonomy());
        return $object->addCompositeId($composite_id);
    }

}