<?php

namespace spec\Scato\Serializer\Json;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use stdClass;

class JsonEncoderSpec extends ObjectBehavior
{
    function it_should_be_an_encoder()
    {
        $this->shouldHaveType('Scato\Serializer\Core\EncoderInterface');
    }

    function it_should_encode_an_empty_array()
    {
        $this->encode(array())->shouldBe('[]');
    }

    function it_should_encode_an_array_with_a_string()
    {
        $this->encode(array('foo'))->shouldBe('["foo"]');
    }

    function it_should_encode_an_array_with_an_array()
    {
        $this->encode(array(array('foo')))->shouldBe('[["foo"]]');
    }

    function it_should_encode_an_empty_object()
    {
        $object = new stdClass();

        $this->encode($object)->shouldBe('{}');
    }

    function it_should_encode_an_object_with_a_string()
    {
        $object = new stdClass();
        $object->foo = 'bar';

        $this->encode($object)->shouldBe('{"foo":"bar"}');
    }

    function it_should_encode_an_object_with_an_array()
    {
        $object = new stdClass();
        $object->foo = array('bar');

        $this->encode($object)->shouldBe('{"foo":["bar"]}');
    }

    function it_should_encode_a_string()
    {
        $this->encode('foobar')->shouldBe('"foobar"');
    }

    function it_should_encode_a_string_with_a_double_quote()
    {
        $this->encode('foo"bar')->shouldBe('"foo\\"bar"');
    }

    function it_should_encode_null()
    {
        $this->encode(null)->shouldBe('null');
    }

    function it_should_encode_a_number()
    {
        $this->encode(42)->shouldBe('42');
    }

    function it_should_encode_a_boolean()
    {
        $this->encode(true)->shouldBe('true');
    }
}
