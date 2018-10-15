<?php 

namespace Spark\Model\PostType;

use Spark\Media\MediaFile;
use Spark\Model\PostEntity;

/**
 * Class Attachment
 * @package Spark\Model\PostType
 *
 * @property $mime_type
 * @property $metadata
 */
final class Attachment extends PostEntity
{
    const POST_TYPE = 'attachment';

    public function getMediaFile()
    {
        return MediaFile::createFromAttachment($this);
    }

    public function getMimeType()
    {
        return $this->wp_post->post_mime_type;
    }

    public function getMetadata()
    {
        return $this->_metadata['_wp_attachment_metadata'];
    }
}