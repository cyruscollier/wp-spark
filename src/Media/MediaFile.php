<?php

namespace Spark\Media;

use Spark\Model\PostType\Attachment;

class MediaFile extends \SplFileInfo
{
    /**
     * @var Attachment
     */
    protected $Attachment;

    public function __construct($file_name)
    {
        parent::__construct($file_name);
    }

    public static function createFromAttachment(Attachment $Attachment)
    {
        $file_path = get_attached_file($Attachment->id);
        if (!$file_path) {
            throw new \InvalidArgumentException('File not found for attachment: ' . $Attachment->id);
        }
        $file = new static($file_path);
        $file->setAttachment($Attachment);
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
    }


}