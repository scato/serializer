<?php

namespace spec\Scato\Serializer\Url;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UrlDecoderSpec extends ObjectBehavior
{
    function it_should_be_a_decoder()
    {
        $this->shouldHaveType('Scato\Serializer\Core\DecoderInterface');
    }

    function it_should_decode_an_empty_array()
    {
        $this->decode('')->shouldBe(array());
    }

    function it_should_decode_an_array_with_a_string()
    {
        $this->decode('foo=bar')->shouldBe(array('foo' => 'bar'));
    }

    function it_should_decode_an_array_with_an_array()
    {
        $this->decode('foo%5B0%5D=bar')->shouldBe(array('foo' => array('bar')));
    }

    function it_should_decode_an_array_with_a_string_with_a_space()
    {
        $this->decode('0=foo+bar')->shouldBe(array('foo bar'));
    }
}
