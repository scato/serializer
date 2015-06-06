<?php

namespace spec\Scato\Serializer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\EncoderInterface;
use Scato\Serializer\ObjectAccessorInterface;
use Scato\Serializer\ValueVisitorInterface;
use stdClass;

class NavigatorSpec extends ObjectBehavior
{
    function let(ObjectAccessorInterface $objectAccessor)
    {
        $this->beConstructedWith($objectAccessor);
    }

    function it_should_accept_an_empty_array(ValueVisitorInterface $visitor)
    {
        $visitor->visitArrayStart()->shouldBeCalled();
        $visitor->visitArrayEnd()->shouldBeCalled();

        $this->accept($visitor, array());
    }

    function it_should_accept_an_array_with_a_string(ValueVisitorInterface $visitor)
    {
        $visitor->visitArrayStart()->shouldBeCalled();
        $visitor->visitElementStart('foo')->shouldBeCalled();
        $visitor->visitString('bar')->shouldBeCalled();
        $visitor->visitElementEnd('foo')->shouldBeCalled();
        $visitor->visitArrayEnd()->shouldBeCalled();

        $this->accept($visitor, array('foo' => 'bar'));
    }

    function it_should_accept_an_array_with_an_array(ValueVisitorInterface $visitor)
    {
        $visitor->visitArrayStart()->shouldBeCalled();
        $visitor->visitElementStart(0)->shouldBeCalled();
        $visitor->visitArrayStart()->shouldBeCalled();
        $visitor->visitElementStart(0)->shouldBeCalled();
        $visitor->visitString('foo')->shouldBeCalled();
        $visitor->visitElementEnd(0)->shouldBeCalled();
        $visitor->visitArrayEnd()->shouldBeCalled();
        $visitor->visitElementEnd(0)->shouldBeCalled();
        $visitor->visitArrayEnd()->shouldBeCalled();

        $this->accept($visitor, array(array('foo')));
    }

    function it_should_accept_an_empty_object(
        ObjectAccessorInterface $objectAccessor,
        ValueVisitorInterface $visitor
    ) {
        $object = new stdClass();

        $visitor->visitObjectStart('stdClass')->shouldBeCalled();
        $visitor->visitObjectEnd('stdClass')->shouldBeCalled();

        $objectAccessor->getNames($object)->willReturn(array());

        $this->accept($visitor, $object);
    }

    function it_should_accept_an_object_with_a_string(
        ObjectAccessorInterface $objectAccessor,
        ValueVisitorInterface $visitor
    ) {
        $object = new stdClass();

        $visitor->visitObjectStart('stdClass')->shouldBeCalled();
        $visitor->visitPropertyStart('foo')->shouldBeCalled();
        $visitor->visitString('bar')->shouldBeCalled();
        $visitor->visitPropertyEnd('foo')->shouldBeCalled();
        $visitor->visitObjectEnd('stdClass')->shouldBeCalled();

        $objectAccessor->getNames($object)->willReturn(array('foo'));
        $objectAccessor->getValue($object, 'foo')->willReturn('bar');

        $this->accept($visitor, $object);
    }

    function it_should_accept_an_object_with_an_array(
        ObjectAccessorInterface $objectAccessor,
        ValueVisitorInterface $visitor
    ) {
        $object = new stdClass();

        $visitor->visitObjectStart('stdClass')->shouldBeCalled();
        $visitor->visitPropertyStart('foo')->shouldBeCalled();
        $visitor->visitArrayStart()->shouldBeCalled();
        $visitor->visitElementStart(0)->shouldBeCalled();
        $visitor->visitString('bar')->shouldBeCalled();
        $visitor->visitElementEnd(0)->shouldBeCalled();
        $visitor->visitArrayEnd()->shouldBeCalled();
        $visitor->visitPropertyEnd('foo')->shouldBeCalled();
        $visitor->visitObjectEnd('stdClass')->shouldBeCalled();

        $objectAccessor->getNames($object)->willReturn(array('foo'));
        $objectAccessor->getValue($object, 'foo')->willReturn(array('bar'));

        $this->accept($visitor, $object);
    }

    function it_should_accept_a_string(ValueVisitorInterface $visitor)
    {
        $visitor->visitString('foobar')->shouldBeCalled();

        $this->accept($visitor, 'foobar');
    }

    function it_should_accept_null(ValueVisitorInterface $visitor)
    {
        $visitor->visitNull()->shouldBeCalled();

        $this->accept($visitor, null);
    }

    function it_should_accept_a_number(ValueVisitorInterface $visitor)
    {
        $visitor->visitNumber(1)->shouldBeCalled();

        $this->accept($visitor, 1);
    }

    function it_should_accept_a_boolean(ValueVisitorInterface $visitor)
    {
        $visitor->visitBoolean(true)->shouldBeCalled();

        $this->accept($visitor, true);
    }
}
