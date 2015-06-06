<?php

namespace spec\Scato\Serializer\Common;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Common\PublicAccessor;
use stdClass;

class ObjectToArrayVisitorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new PublicAccessor());
    }

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
        $this->visitString('bar');
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
        $this->visitString('foo');
        $this->visitElementEnd(0);
        $this->visitArrayEnd();
        $this->visitElementEnd(0);
        $this->visitArrayEnd();

        $this->getResult()->shouldBe(array(array('foo')));
    }

    function it_should_handle_an_empty_object() {
        $this->visitObjectStart('ExampleObject');
        $this->visitObjectEnd('ExampleObject');

        $this->getResult()->shouldBeLike(array());
    }

    function it_should_handle_an_object_with_a_string() {
        $this->visitObjectStart('ExampleObject');
        $this->visitPropertyStart('foo');
        $this->visitString('bar');
        $this->visitPropertyEnd('foo');
        $this->visitObjectEnd('ExampleObject');

        $this->getResult()->shouldBeLike(array('foo' => 'bar'));
    }

    function it_should_handle_an_object_with_an_array() {
        $this->visitObjectStart('ExampleObject');
        $this->visitPropertyStart('foo');
        $this->visitArrayStart();
        $this->visitElementStart(0);
        $this->visitString('bar');
        $this->visitElementEnd(0);
        $this->visitArrayEnd();
        $this->visitPropertyEnd('foo');
        $this->visitObjectEnd('ExampleObject');

        $this->getResult()->shouldBeLike(array('foo' => array('bar')));
    }

    function it_should_handle_a_string()
    {
        $this->visitString('foobar');

        $this->getResult()->shouldBe('foobar');
    }

    function it_should_handle_null()
    {
        $this->visitNull();

        $this->getResult()->shouldBe(null);
    }

    function it_should_handle_a_number()
    {
        $this->visitNumber(1);

        $this->getResult()->shouldBe(1);
    }

    function it_should_handle_a_boolean()
    {
        $this->visitBoolean(true);

        $this->getResult()->shouldBe(true);
    }
}
