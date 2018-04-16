<?php 

namespace Spark\Model\Values;

/**
 * Base class for values that have an associated filter
 * 
 * @author cyruscollier
 *
 */
abstract class TermFilteredValue extends FilteredValue
{
    /**
     * @var TermCompositeId $composite_id
     */
    protected $composite_id;

    public function addCompositeId(TermCompositeId $composite_id)
    {
        $object = new static($this->value);
        $object->composite_id = $composite_id;
        return $object;
    }
}
