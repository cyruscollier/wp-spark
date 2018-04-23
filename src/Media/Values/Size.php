<?php

namespace Spark\Media\Values;

final class Size
{
    private $width;

    private $height;

    /**
     * ImageDimensions constructor.
     * @param $width
     * @param $height
     */
    public function __construct($width, $height)
    {
        $this->width = (int) $width;
        $this->height = (int) $height;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }




}