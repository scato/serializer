<?php

namespace spec\Scato\Serializer\ObjectAccess;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Core\Type;
use stdClass;

class SimpleObjectFactorySpec extends ObjectBehavior
{
    function it_should_be_an_object_factory()
    {
        $this->shouldHaveType('Scato\Serializer\Navigation\ObjectFactoryInterface');
    }

    function it_should_create_an_object()
    {
        $object = new stdClass();
        $object->foo = 'bar';

        $type = Type::fromString('stdClass');
        $value = ['foo' => 'bar'];

        $this->createObject($type, $value)->shouldBeLike($object);
    }

    function it_should_not_create_an_object_without_knowing_its_type()
    {
        $exception = new InvalidArgumentException("Cannot create object for non-class type: 'mixed'");

        $type = Type::fromString(null);
        $value = ['foo' => 'bar'];

        $this->shouldThrow($exception)->duringCreateObject($type, $value);
    }

    function it_should_only_accept_arrays()
    {
        $exception = new InvalidArgumentException("Cannot create object from non-array value: 'foo'");

        $type = Type::fromString('stdClass');
        $value = 'foo';

        $this->shouldThrow($exception)->duringCreateObject($type, $value);
    }
}
