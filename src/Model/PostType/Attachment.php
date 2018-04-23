<?php 

namespace Spark\Model\PostType;

use Spark\Media\MediaFile;
use Spark\Model\PostEntity;

/**
 * Class Attachment
 * @package Spark\Model\PostType
 *
 * @property $mime_type
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
}