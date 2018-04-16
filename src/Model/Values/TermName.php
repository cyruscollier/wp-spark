<?php 

namespace Spark\Model\Values;

/**
 * Filtered value object for post_title
 * 
 * @author cyruscollier
 *
 */
class TermName extends TermFilteredValue
{
    protected static $taxonomy_filter_map = [
        'category' => 'cat',
        'post_tag' => 'tag',
        'term' => 'term'
    ];

    /**
     * Name used for filter
     *
     * @var string
     */
    protected $filter = 'term_name';

    public function asSingleTitle()
    {
        $taxonomy = $this->composite_id ? $this->composite_id->getTaxonomy() : 'term';
        $filter_tax = static::$taxonomy_filter_map[$taxonomy] ?? 'term';
        return apply_filters("single_{$filter_tax}_title", $this->value);
    }
}