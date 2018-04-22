<?php 

namespace Spark\Model\PostType;

use Spark\Media\MediaFile;
use Spark\Model\PostType;

final class Attachment extends PostType
{
    const POST_TYPE = 'attachment';

    public function getMediaFile()
    {
        return MediaFile::createFromAttachment($this);
    }
}