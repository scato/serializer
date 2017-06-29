<?php

namespace spec\Scato\Serializer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Data\DataMapperFactory;
use Scato\Serializer\Data\Mapper;
use Scato\Serializer\Navigation\DeserializationFilterInterface;
use Scato\Serializer\Navigation\SerializationConverterInterface;

class MapperFacadeSpec extends ObjectBehavior
{
    function let(DataMapperFactory $mapperFactory)
    {
        $this->beConstructedWith($mapperFactory);
    }

    function it_should_map_values(
        DataMapperFactory $mapperFactory,
        Mapper $mapper,
        SerializationConverterInterface $converter,
        DeserializationFilterInterface $filter
    ) {
        $mapperFactory->createMapper([$converter], [$filter])->willReturn($mapper);
        $mapper->map('bar', 'Foo')->willReturn('foo');

        $this->addSerializationConverter($converter);
        $this->addDeserializationFilter($filter);
        $this->map('bar', 'Foo')->shouldBe('foo');
    }
}
