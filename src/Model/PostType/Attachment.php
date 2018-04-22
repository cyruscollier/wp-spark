<?php 

namespace Spark\Model\PostType;

use Spark\Media\MediaFile;
use Spark\Model\PostEntity;

final class Attachment extends PostEntity
{
    const POST_TYPE = 'attachment';

    public function getMediaFile()
    {
        return MediaFile::createFromAttachment($this);
    }
}