<?php

namespace spec\Scato\Serializer;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Core\AbstractDeserializerFactory;
use Scato\Serializer\Core\AbstractSerializerFactory;
use Scato\Serializer\Core\Deserializer;
use Scato\Serializer\Core\Serializer;
use Scato\Serializer\Navigation\SerializationConverterInterface;

class SerializerFacadeSpec extends ObjectBehavior
{
    function let(
        AbstractSerializerFactory $serializerFactory,
        AbstractDeserializerFactory $deserializerFactory
    ) {
        $this->beConstructedWith(
            ['my-format' => $serializerFactory],
            ['my-format' => $deserializerFactory]
        );
    }

    function it_cannot_serialize_values_to_unknown_formats() {
        $this->shouldThrow(new InvalidArgumentException('Unknown format \'unknown-format\''))
            ->duringSerialize('foo', 'unknown-format');
    }

    function it_should_serialize_values(
        AbstractSerializerFactory $serializerFactory,
        Serializer $serializer,
        SerializationConverterInterface $converter
    ) {
        $serializerFactory->createSerializer([$converter])->willReturn($serializer);
        $serializer->serialize('foo')->willReturn('bar');

        $this->addSerializationConverter($converter);
        $this->serialize('foo', 'my-format')->shouldBe('bar');
    }

    function it_cannot_deserialize_values_from_unknown_formats() {
        $this->shouldThrow(new InvalidArgumentException('Unknown format \'unknown-format\''))
            ->duringDeserialize('bar', 'Foo', 'unknown-format');
    }

    function it_should_deserialize_values(
        AbstractDeserializerFactory $deserializerFactory,
        Deserializer $deserializer
    ) {
        $deserializerFactory->createDeserializer()->willReturn($deserializer);
        $deserializer->deserialize('bar', 'Foo')->willReturn('foo');

        $this->deserialize('bar', 'Foo', 'my-format')->shouldBe('foo');
    }
}
