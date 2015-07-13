<?php

namespace spec\Scato\Serializer\Navigation;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Core\VisitorInterface;
use Scato\Serializer\Navigation\ObjectAccessorInterface;
use stdClass;

class NavigatorSpec extends ObjectBehavior
{
    function let(ObjectAccessorInterface $objectAccessor)
    {
        $this->beConstructedWith($objectAccessor);
    }

    function it_should_be_a_navigator()
    {
        $this->shouldHaveType('Scato\Serializer\Core\NavigatorInterface');
    }

    function it_should_accept_an_empty_array(VisitorInterface $visitor)
    {
        $visitor->visitArrayStart()->shouldBeCalled();
        $visitor->visitArrayEnd()->shouldBeCalled();

        $this->accept($visitor, array());
    }

    function it_should_accept_an_array_with_a_string(VisitorInterface $visitor)
    {
        $visitor->visitArrayStart()->shouldBeCalled();
        $visitor->visitElementStart('foo')->shouldBeCalled();
        $visitor->visitValue('bar')->shouldBeCalled();
        $visitor->visitElementEnd('foo')->shouldBeCalled();
        $visitor->visitArrayEnd()->shouldBeCalled();

        $this->accept($visitor, array('foo' => 'bar'));
    }

    function it_should_accept_an_array_with_an_array(VisitorInterface $visitor)
    {
        $visitor->visitArrayStart()->shouldBeCalled();
        $visitor->visitElementStart(0)->shouldBeCalled();
        $visitor->visitArrayStart()->shouldBeCalled();
        $visitor->visitElementStart(0)->shouldBeCalled();
        $visitor->visitValue('foo')->shouldBeCalled();
        $visitor->visitElementEnd(0)->shouldBeCalled();
        $visitor->visitArrayEnd()->shouldBeCalled();
        $visitor->visitElementEnd(0)->shouldBeCalled();
        $visitor->visitArrayEnd()->shouldBeCalled();

        $this->accept($visitor, array(array('foo')));
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

    function it_should_accept_an_object_with_a_string(
        ObjectAccessorInterface $objectAccessor,
        VisitorInterface $visitor
    ) {
        $object = new stdClass();

        $visitor->visitArrayStart()->shouldBeCalled();
        $visitor->visitElementStart('foo')->shouldBeCalled();
        $visitor->visitValue('bar')->shouldBeCalled();
        $visitor->visitElementEnd('foo')->shouldBeCalled();
        $visitor->visitArrayEnd()->shouldBeCalled();

        $objectAccessor->getNames($object)->willReturn(array('foo'));
        $objectAccessor->getValue($object, 'foo')->willReturn('bar');

        $this->accept($visitor, $object);
    }

    function it_should_accept_an_object_with_an_array(
        ObjectAccessorInterface $objectAccessor,
        VisitorInterface $visitor
    ) {
        $object = new stdClass();

        $visitor->visitArrayStart()->shouldBeCalled();
        $visitor->visitElementStart('foo')->shouldBeCalled();
        $visitor->visitArrayStart()->shouldBeCalled();
        $visitor->visitElementStart(0)->shouldBeCalled();
        $visitor->visitValue('bar')->shouldBeCalled();
        $visitor->visitElementEnd(0)->shouldBeCalled();
        $visitor->visitArrayEnd()->shouldBeCalled();
        $visitor->visitElementEnd('foo')->shouldBeCalled();
        $visitor->visitArrayEnd()->shouldBeCalled();

        $objectAccessor->getNames($object)->willReturn(array('foo'));
        $objectAccessor->getValue($object, 'foo')->willReturn(array('bar'));

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