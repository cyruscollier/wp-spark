<?php

namespace Spark\Repository;

use Spark\Model\TermEntity;
use Spark\Model\Values\Permalink;
use Spark\Model\Values\TermCompositeId;
use Spark\Support\Entity\TermFactory;
use Spark\Model\EntityCollection;
use Spark\Model\PostEntity;
use Spark\Support\Query\TermQueryBuilder;
use Spark\Support\Entity\TermEntityRepository as Repository;

class TermEntityRepository implements Repository
{
    protected $Query;

    protected $Factory;

    protected static $allowed_taxonomies = [];

    public function __construct(TermQueryBuilder $Query, TermFactory $Factory)
    {
        $this->Query = $Query;
        $this->Factory = $Factory;
    }

    public function find(array $params = []): EntityCollection
    {
        $this->Query->where($params);
        return $this->getTerms();
    }

    public function findAll($taxonomy = null): EntityCollection
    {
        if ($taxonomy) {
            $this->Query->withTaxonomy($taxonomy);
        }
        $this->Query->all();
        return $this->getTerms();
    }

    /**
     * @param int|TermCompositeId $id
     * @return TermEntity
     * @throws \Exception
     */
    public function findById($id): TermEntity
    {
        $taxonomy = '';
        if ($id instanceof TermCompositeId) {
            $taxonomy = $id->getTaxonomy();
            $id = $id->getId();
        }
        $term = get_term($id, $taxonomy);
        return $this->getTerm($term);
    }

    public function findOne(array $params = []): TermEntity
    {
        $this->Query->one();
        $Collection = $this->getTerms();
        return $Collection[0];
    }

    function findForPost(PostEntity $Post, $taxonomy = null): EntityCollection
    {
        $this->Query->where(['object_ids' => [$Post->id]]);
        if ($taxonomy) {
            $this->Query->withTaxonomy($taxonomy);
        }
        return $this->getTerms();
    }


//    public function add($object)
//    {
//        // TODO: Implement add() method.
//    }
//
//    public function remove($object)
//    {
//        // TODO: Implement remove() method.
//    }

    /**
     * @param \WP_Term $term
     * @return TermEntity
     * @throws \Exception
     */
    protected function getTerm(\WP_Term $term)
    {
        $taxonomy = $this->getTaxonomy();
        if ($taxonomy && !in_array($term->taxonomy, $taxonomy)) {
            throw new \InvalidArgumentException('Term does not match allowed taxonomy(ies)');
        }
        $raw_metadata = get_term_meta($term->term_id);
        $metadata = array_map(function($m) {
            return $m[0];
        }, $raw_metadata);
        $Term = $this->Factory->createFromWPTerm($term, $metadata);
        $Term->setPermalink(new Permalink(get_term_link($term)));
        return $Term;
    }

    protected function getTerms()
    {
        if ($taxonomy = $this->getTaxonomy()) {
            $this->Query->withTaxonomy($taxonomy);
        }
        $terms = get_terms($this->Query->build());
        $Collection = new EntityCollection();
        foreach ($terms as $term) {
            $Term = $this->getTerm($term);
            $Collection->add($Term);
        }
        return $Collection;
    }

    protected function getTaxonomy()
    {
        return static::$allowed_taxonomies ? (array) static::$allowed_taxonomies : [];
    }

}