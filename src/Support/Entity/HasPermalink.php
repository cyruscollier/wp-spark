<?php

namespace Spark\Support\Entity;

use Spark\Model\Values\Permalink;

interface HasPermalink
{
    function getPermalink(): Permalink;

    function setPermalink(Permalink $permalink);
}