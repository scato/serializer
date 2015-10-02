<?php

namespace spec\Scato\Serializer\Xml;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class XmlDeserializerFactorySpec extends ObjectBehavior
{
    function it_should_be_a_deserializer_factory()
    {
        $this->shouldHaveType('Scato\Serializer\Core\AbstractDeserializerFactory');
    }

    function it_should_create_a_deserializer()
    {
        $this->createDeserializer()->shouldHaveType('Scato\Serializer\Core\Deserializer');
    }
}
