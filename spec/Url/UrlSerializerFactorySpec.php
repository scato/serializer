<?php

namespace spec\Scato\Serializer\Url;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UrlSerializerFactorySpec extends ObjectBehavior
{
    function it_should_be_a_serializer_factory()
    {
        $this->shouldHaveType('Scato\Serializer\Core\AbstractSerializerFactory');
    }

    function it_should_create_a_serializer()
    {
        $this->createSerializer()->shouldHaveType('Scato\Serializer\Core\Serializer');
    }
}
