<?php

namespace spec\Scato\Serializer\Navigation;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Core\NavigatorInterface;
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

    function it_should_accept_an_empty_array(NavigatorInterface $navigator, VisitorInterface $visitor)
    {
        $visitor->visitArrayStart()->shouldBeCalled();
        $visitor->visitArrayEnd()->shouldBeCalled();

        $this->accept($navigator, $visitor, array());
    }

    function it_should_accept_an_array_with_a_string(NavigatorInterface $navigator, VisitorInterface $visitor)
    {
        $visitor->visitArrayStart()->shouldBeCalled();
        $visitor->visitElementStart('foo')->shouldBeCalled();
        $visitor->visitValue('bar')->shouldBeCalled();
        $visitor->visitElementEnd('foo')->shouldBeCalled();
        $visitor->visitArrayEnd()->shouldBeCalled();

        $this->accept($navigator, $visitor, array('foo' => 'bar'));
    }

    function it_should_accept_an_array_with_an_array(NavigatorInterface $navigator, VisitorInterface $visitor)
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

        $this->accept($navigator, $visitor, array(array('foo')));
    }

    function it_should_accept_an_empty_object(
        NavigatorInterface $navigator,
        ObjectAccessorInterface $objectAccessor,
        VisitorInterface $visitor
    ) {
        $object = new stdClass();

        $visitor->visitArrayStart()->shouldBeCalled();
        $visitor->visitArrayEnd()->shouldBeCalled();

        $objectAccessor->getNames($object)->willReturn(array());

        $this->accept($navigator, $visitor, $object);
    }

    function it_should_accept_an_object_with_a_string(
        NavigatorInterface $navigator,
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

        $this->accept($navigator, $visitor, $object);
    }

    function it_should_accept_an_object_with_an_array(
        NavigatorInterface $navigator,
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

        $this->accept($navigator, $visitor, $object);
    }

    function it_should_accept_a_string(NavigatorInterface $navigator, VisitorInterface $visitor)
    {
        $visitor->visitValue('foobar')->shouldBeCalled();

        $this->accept($navigator, $visitor, 'foobar');
    }

    function it_should_accept_null(NavigatorInterface $navigator, VisitorInterface $visitor)
    {
        $visitor->visitValue(null)->shouldBeCalled();

        $this->accept($navigator, $visitor, null);
    }

    function it_should_accept_a_number(NavigatorInterface $navigator, VisitorInterface $visitor)
    {
        $visitor->visitValue(1)->shouldBeCalled();

        $this->accept($navigator, $visitor, 1);
    }

    function it_should_accept_a_boolean(NavigatorInterface $navigator, VisitorInterface $visitor)
    {
        $visitor->visitValue(true)->shouldBeCalled();

        $this->accept($navigator, $visitor, true);
    }
}
