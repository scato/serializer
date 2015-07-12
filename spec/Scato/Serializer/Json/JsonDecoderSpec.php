<?php

namespace spec\Scato\Serializer\Json;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use stdClass;

class JsonDecoderSpec extends ObjectBehavior
{
    function it_should_be_a_decoder()
    {
        $this->shouldHaveType('Scato\Serializer\Core\DecoderInterface');
    }

    function it_should_decode_an_empty_array()
    {
        $this->decode('[]')->shouldBe(array());
    }

    function it_should_decode_an_array_with_a_string()
    {
        $this->decode('["foo"]')->shouldBe(array('foo'));
    }

    function it_should_decode_an_array_with_an_array()
    {
        $this->decode('[["foo"]]')->shouldBe(array(array('foo')));
    }

    function it_should_decode_an_empty_object()
    {
        $this->decode('{}')->shouldBeLike(array());
    }

    function it_should_decode_an_object_with_a_string()
    {
        $this->decode('{"foo":"bar"}')->shouldBeLike(array('foo' => 'bar'));
    }

    function it_should_decode_an_object_with_an_array()
    {
        $this->decode('{"foo":["bar"]}')->shouldBeLike(array('foo' => array('bar')));
    }

    function it_should_decode_a_string()
    {
        $this->decode('"foobar"')->shouldBe('foobar');
    }

    function it_should_decode_a_string_with_a_double_quote()
    {
        $this->decode('"foo\\"bar"')->shouldBe('foo"bar');
    }

    function it_should_decode_null()
    {
        $this->decode('null')->shouldBe(null);
    }

    function it_should_decode_a_number()
    {
        $this->decode('42')->shouldBe(42);
    }

    function it_should_decode_a_boolean()
    {
        $this->decode('true')->shouldBe(true);
    }
}
