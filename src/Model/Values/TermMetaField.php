<?php 

namespace Spark\Model\Values;

/**
 * A term metadata field
 * 
 * @author cyruscollier
 *
 */
class TermMetaField extends MetadataField
{
    public function getType() { return 'term'; }
}