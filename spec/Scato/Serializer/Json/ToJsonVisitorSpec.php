<?php

namespace spec\Scato\Serializer\Json;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Common\PublicAccessor;
use stdClass;

class ToJsonVisitorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new PublicAccessor());
    }

    function it_should_be_an_object_to_array_visitor()
    {
        $this->shouldHaveType('Scato\Serializer\Common\ObjectToArrayVisitor');
    }

    function it_should_handle_an_empty_object() {
        $object = new stdClass();

        $this->visitObjectStart('ExampleObject');
        $this->visitObjectEnd('ExampleObject');

        $this->getResult()->shouldBeLike($object);
    }

    function it_should_handle_an_object_with_a_string() {
        $object = new stdClass();
        $object->foo = 'bar';

        $this->visitObjectStart('ExampleObject');
        $this->visitPropertyStart('foo');
        $this->visitString('bar');
        $this->visitPropertyEnd('foo');
        $this->visitObjectEnd('ExampleObject');

        $this->getResult()->shouldBeLike($object);
    }

    function it_should_handle_an_object_with_an_array() {
        $object = new stdClass();
        $object->foo = array('bar');

        $this->visitObjectStart('ExampleObject');
        $this->visitPropertyStart('foo');
        $this->visitArrayStart();
        $this->visitElementStart(0);
        $this->visitString('bar');
        $this->visitElementEnd(0);
        $this->visitArrayEnd();
        $this->visitPropertyEnd('foo');
        $this->visitObjectEnd('ExampleObject');

        $this->getResult()->shouldBeLike($object);
    }
}
