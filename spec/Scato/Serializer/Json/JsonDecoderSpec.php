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
        $object = new stdClass();

        $this->decode('{}')->shouldBeLike($object);
    }

    function it_should_decode_an_object_with_a_string()
    {
        $object = new stdClass();
        $object->foo = 'bar';

        $this->decode('{"foo":"bar"}')->shouldBeLike($object);
    }

    function it_should_decode_an_object_with_an_array()
    {
        $object = new stdClass();
        $object->foo = array('bar');

        $this->decode('{"foo":["bar"]}')->shouldBeLike($object);
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
