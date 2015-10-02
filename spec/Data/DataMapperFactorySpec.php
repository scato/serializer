<?php

namespace spec\Scato\Serializer\Data;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DataMapperFactorySpec extends ObjectBehavior
{
    function it_should_create_a_mapper()
    {
        $this->createMapper()->shouldHaveType('Scato\Serializer\Data\Mapper');
    }
}
