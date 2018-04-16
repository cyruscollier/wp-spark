<?php

namespace Spark\Factory;

use Spark\Model\Taxonomy;
use Spark\Model\Values;
use Spark\Support\Entity\EntityRegistry;
use Spark\Support\Entity\TermFactory as Factory;

final class TermFactory implements Factory
{
    /**
     * @var EntityRegistry
     */
    protected $Registry;

    public function __construct(EntityRegistry $Registry)
    {
        $this->Registry = $Registry;
    }

    /**
     * @param $data
     * @return Taxonomy
     * @throws \Exception
     */
    public function create($data): Taxonomy
    {
        $id = $data['id'] ?? null;
        $Term = $this->createInstance($data['taxonomy'], $id);
        $this->setIds($data, $Term);
        $this->setValues($data, $Term);
        return $Term;
    }

    /**
     * @param \WP_Term $term
     * @param array $metadata
     * @return Taxonomy
     * @throws \Exception
     */
    function createFromWPTerm(\WP_Term $term, array $metadata = []): Taxonomy
    {
        $data = [
            'id' => $term->term_id,
            'taxonomy' => $term->taxonomy,
            'parent_id' => $term->parent,
            'post_count' => $term->count,
            'name' => $term->name,
            'description' => $term->description,
            'slug' => $term->slug
        ];
        $Term = $this->create($data);
        $Term->wp_term = $term;
        foreach ( $metadata as $key => $value) {
            $Term->setMetadata(new Values\TermMetaField($key, $value));
        }
        return $Term;
    }

    protected function createInstance($taxonomy, $id): Taxonomy
    {
        $term_class = $this->Registry->getByKey($taxonomy);
        if (!is_a($term_class, Taxonomy::class, true)) {
            throw new \InvalidArgumentException('Supplied taxonomy does not have a registered Taxonomy class:' . $taxonomy);
        }
        return new $term_class($id);
    }

    /**
     * @param $data
     * @param $Term
     */
    protected function setIds(&$data, Taxonomy $Term)
    {
        foreach (['parent_id', 'post_count'] as $key) {
            if (isset($data[$key])) {
                $Term->{$key} = (int) $data[$key];
            }
        }
    }

    /**
     * @param $data
     * @param $Term
     */
    protected function setValues(&$data, Taxonomy $Term)
    {
        $map = [
            'name' => Values\TermName::class,
            'description' => Values\TermDescription::class,
            'slug' => Values\Slug::class,
        ];
        foreach ($map as $key => $class) {
            if (isset($data[$key])) {
                $Term->{$key} = is_a($data[$key], $class, true) ?
                    $data[$key] : new $class($data[$key]);
            }
        }
    }
}