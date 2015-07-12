<?php

namespace spec\Scato\Serializer\Json;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use stdClass;

class ToJsonVisitorSpec extends ObjectBehavior
{
    function it_should_be_an_object_to_array_visitor()
    {
        $this->shouldHaveType('Scato\Serializer\Common\SerializeVisitor');
    }

    function it_should_handle_an_empty_object() {
        $this->visitObjectStart();
        $this->visitObjectEnd();

        $this->getResult()->shouldBeLike(array());
    }

    function it_should_handle_an_object_with_a_string() {
        $this->visitObjectStart();
        $this->visitPropertyStart('foo');
        $this->visitValue('bar');
        $this->visitPropertyEnd('foo');
        $this->visitObjectEnd();

        $this->getResult()->shouldBeLike(array('foo' => 'bar'));
    }

    function it_should_handle_an_object_with_an_array() {
        $this->visitObjectStart();
        $this->visitPropertyStart('foo');
        $this->visitArrayStart();
        $this->visitElementStart(0);
        $this->visitValue('bar');
        $this->visitElementEnd(0);
        $this->visitArrayEnd();
        $this->visitPropertyEnd('foo');
        $this->visitObjectEnd();

        $this->getResult()->shouldBeLike(array('foo' => array('bar')));
    }
}
