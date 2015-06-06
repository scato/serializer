<?php

namespace spec\Scato\Serializer\Url;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UrlEncoderSpec extends ObjectBehavior
{
    function it_should_be_an_encoder()
    {
        $this->shouldHaveType('Scato\Serializer\Core\EncoderInterface');
    }

    function it_should_encode_an_empty_array()
    {
        $this->encode(array())->shouldBe('');
    }

    function it_should_encode_an_array_with_a_string()
    {
        $this->encode(array('foo' => 'bar'))->shouldBe('foo=bar');
    }

    function it_should_encode_an_array_with_an_array()
    {
        $this->encode(array('foo' => array('bar')))->shouldBe('foo%5B0%5D=bar');
    }

    function it_should_encode_an_array_with_a_string_with_a_space()
    {
        $this->encode(array('foo bar'))->shouldBe('0=foo+bar');
    }
}
