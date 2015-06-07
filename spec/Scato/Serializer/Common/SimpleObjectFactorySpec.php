<?php

namespace spec\Scato\Serializer\Common;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
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

        $this->createObject('stdClass', array('foo' => 'bar'))->shouldBeLike($object);
    }
}
