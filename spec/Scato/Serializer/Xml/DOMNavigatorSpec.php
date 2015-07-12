<?php

namespace spec\Scato\Serializer\Xml;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Core\EncoderInterface;
use Scato\Serializer\Core\ObjectAccessorInterface;
use Scato\Serializer\Core\VisitorInterface;
use stdClass;

class DOMNavigatorSpec extends ObjectBehavior
{
    function let(ObjectAccessorInterface $objectAccessor)
    {
        $this->beConstructedWith($objectAccessor);
    }

    function it_should_accept_an_empty_object(
        ObjectAccessorInterface $objectAccessor,
        VisitorInterface $visitor
    ) {
        $object = new stdClass();

        $visitor->visitArrayStart()->shouldBeCalled();
        $visitor->visitArrayEnd()->shouldBeCalled();

        $objectAccessor->getNames($object)->willReturn(array());

        $this->accept($visitor, $object);
    }

    function it_should_accept_an_object_with_an_array(
        ObjectAccessorInterface $objectAccessor,
        VisitorInterface $visitor
    ) {
        $object = new stdClass();

        $visitor->visitArrayStart()->shouldBeCalled();
        $visitor->visitElementStart('entry')->shouldBeCalled();
        $visitor->visitValue('foo')->shouldBeCalled();
        $visitor->visitElementEnd('entry')->shouldBeCalled();
        $visitor->visitElementStart('entry')->shouldBeCalled();
        $visitor->visitValue('bar')->shouldBeCalled();
        $visitor->visitElementEnd('entry')->shouldBeCalled();
        $visitor->visitArrayEnd()->shouldBeCalled();

        $objectAccessor->getNames($object)->willReturn(array('entry'));
        $objectAccessor->getValue($object, 'entry')->willReturn(array('foo', 'bar'));

        $this->accept($visitor, $object);
    }

    function it_should_accept_a_string(VisitorInterface $visitor)
    {
        $visitor->visitValue('foobar')->shouldBeCalled();

        $this->accept($visitor, 'foobar');
    }

    function it_should_accept_null(VisitorInterface $visitor)
    {
        $visitor->visitValue(null)->shouldBeCalled();

        $this->accept($visitor, null);
    }

    function it_should_accept_a_number(VisitorInterface $visitor)
    {
        $visitor->visitValue(1)->shouldBeCalled();

        $this->accept($visitor, 1);
    }

    function it_should_accept_a_boolean(VisitorInterface $visitor)
    {
        $visitor->visitValue(true)->shouldBeCalled();

        $this->accept($visitor, true);
    }
}
