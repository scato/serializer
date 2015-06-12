<?php

namespace spec\Scato\Serializer\Common;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Core\Type;
use stdClass;

class SimpleObjectFactorySpec extends ObjectBehavior
{
    function it_should_be_an_object_factory()
    {
        $this->shouldHaveType('Scato\Serializer\Common\ObjectFactoryInterface');
    }

    function it_should_create_an_object()
    {
        $object = new stdClass();
        $object->foo = 'bar';

        $type = Type::fromString('stdClass');

        $this->createObject($type, array('foo' => 'bar'))->shouldBeLike($object);
    }

    function it_should_not_create_an_object_without_knowing_its_type()
    {
        $type = Type::fromString(null);

        $this->shouldThrow(new InvalidArgumentException("Cannot create object for non-class type: 'mixed'"))
            ->duringCreateObject($type, array('foo' => 'bar'));
    }
}
