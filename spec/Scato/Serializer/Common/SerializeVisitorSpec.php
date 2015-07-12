<?php

namespace spec\Scato\Serializer\Common;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SerializeVisitorSpec extends ObjectBehavior
{
    function it_should_be_a_visitor()
    {
        $this->shouldHaveType('Scato\Serializer\Core\VisitorInterface');
    }

    function it_should_handle_an_empty_array()
    {
        $this->visitArrayStart();
        $this->visitArrayEnd();

        $this->getResult()->shouldBe(array());
    }

    function it_should_handle_an_array_with_a_string()
    {
        $this->visitArrayStart();
        $this->visitElementStart('foo');
        $this->visitValue('bar');
        $this->visitElementEnd('foo');
        $this->visitArrayEnd();

        $this->getResult()->shouldBe(array('foo' => 'bar'));
    }

    function it_should_handle_an_array_with_an_array()
    {
        $this->visitArrayStart();
        $this->visitElementStart(0);
        $this->visitArrayStart();
        $this->visitElementStart(0);
        $this->visitValue('foo');
        $this->visitElementEnd(0);
        $this->visitArrayEnd();
        $this->visitElementEnd(0);
        $this->visitArrayEnd();

        $this->getResult()->shouldBe(array(array('foo')));
    }

    function it_should_handle_an_empty_object() {
        $this->visitArrayStart();
        $this->visitArrayEnd();

        $this->getResult()->shouldBeLike(array());
    }

    function it_should_handle_an_object_with_a_string() {
        $this->visitArrayStart();
        $this->visitElementStart('foo');
        $this->visitValue('bar');
        $this->visitElementEnd('foo');
        $this->visitArrayEnd();

        $this->getResult()->shouldBeLike(array('foo' => 'bar'));
    }

    function it_should_handle_an_object_with_an_array() {
        $this->visitArrayStart();
        $this->visitElementStart('foo');
        $this->visitArrayStart();
        $this->visitElementStart(0);
        $this->visitValue('bar');
        $this->visitElementEnd(0);
        $this->visitArrayEnd();
        $this->visitElementEnd('foo');
        $this->visitArrayEnd();

        $this->getResult()->shouldBeLike(array('foo' => array('bar')));
    }

    function it_should_handle_a_string()
    {
        $this->visitValue('foobar');

        $this->getResult()->shouldBe('foobar');
    }

    function it_should_handle_null()
    {
        $this->visitValue(null);

        $this->getResult()->shouldBe(null);
    }

    function it_should_handle_a_number()
    {
        $this->visitValue(1);

        $this->getResult()->shouldBe(1);
    }

    function it_should_handle_a_boolean()
    {
        $this->visitValue(true);

        $this->getResult()->shouldBe(true);
    }
}
