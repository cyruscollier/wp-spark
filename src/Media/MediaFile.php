<?php

namespace Spark\Media;

use Spark\Model\PostType\Attachment;
use Spark\Model\Values\PostMetaField;

class MediaFile extends \SplFileInfo
{
    /**
     * @var Attachment
     */
    protected $Attachment;

    protected $relative_file_path;

    protected $mime_type;

    public static function createFromAttachment(Attachment $Attachment)
    {
        $file_path = get_attached_file($Attachment->id);
        if (!$file_path) {
            throw new \InvalidArgumentException('File not found for attachment: ' . $Attachment->id);
        }
        $file = new static($file_path);
        $file->setAttachment($Attachment);
        $file->mime_type = $Attachment->mime_type;
        return $file;
    }

    /**
     * @return Attachment
     */
    public function getAttachment(): Attachment
    {
        return $this->Attachment;
    }

    /**
     * @param Attachment $Attachment
     */
    public function setAttachment(Attachment $Attachment)
    {
        $this->Attachment = $Attachment;
        $this->setMetadata($Attachment->metadata);
    }

    /**
     * @return string
     */
    public function getRelativeFilePath(): string
    {
        return $this->relative_file_path;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mime_type;
    }

    protected function setMetadata(PostMetaField $metadata)
    {
        $data = $metadata->getValue();
        $this->relative_file_path = $data['file'];
    }
}