<?php

namespace Spark\Media;

use Spark\Media\Values\Size;
use Spark\Model\PostType\Attachment;
use Spark\Model\Values\PostMetaField;

class ImageFile extends MediaFile
{
    /**
     * @var Size
     */
    protected $dimensions;

    /**
     * @var array
     */
    protected $sizes;

    /**
     * @var array
     */
    protected $image_meta;

    protected function setMetadata(PostMetaField $metadata)
    {
        $data = $metadata->getValue();
        $this->dimensions = new Size($data['width'], $data['height']);
        $this->sizes = $data['sizes'];
        $this->image_meta = $data['image_meta'];
        parent::setMetadata($metadata);
    }

    /**
     * @return Size
     */
    public function getDimensions(): Size
    {
        return $this->dimensions;
    }

    /**
     * @return array
     */
    public function getSizes()
    {
        return $this->sizes;
    }

    public function getWidth()
    {
        return $this->dimensions->getWidth();
    }

    public function getHeight()
    {
        return $this->dimensions->getHeight();
    }
}