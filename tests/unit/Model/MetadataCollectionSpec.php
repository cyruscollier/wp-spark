<?php

namespace unit\Spark\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MetadataCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Model\MetadataCollection');
    }
}
