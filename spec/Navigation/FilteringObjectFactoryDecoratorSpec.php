<?php

namespace spec\Scato\Serializer\Navigation;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Core\Type;
use Scato\Serializer\Navigation\DeserializationFilterInterface;
use Scato\Serializer\Navigation\ObjectFactoryInterface;
use stdClass;

class FilteringObjectFactoryDecoratorSpec extends ObjectBehavior
{
    function let(ObjectFactoryInterface $objectFactory, DeserializationFilterInterface $filter)
    {
        $this->beConstructedWith($objectFactory, $filter);
    }

    function it_should_be_an_object_factory()
    {
        $this->shouldHaveType('Scato\Serializer\Navigation\ObjectFactoryInterface');
    }

    function it_should_let_the_filter_decide_on_object_creation(
        ObjectFactoryInterface $objectFactory,
        DeserializationFilterInterface $filter,
        Type $type,
        stdClass $object
    ) {
        $value = ['foo' => 'bar'];

        $filter->filter($type, $value, $objectFactory)->willReturn($object);

        $this->createObject($type, $value)->shouldReturn($object);
    }
}
