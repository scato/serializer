<?php

namespace spec\Scato\Serializer\Core;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Core\EncoderInterface;
use Scato\Serializer\Core\NavigatorInterface;
use Scato\Serializer\Core\VisitorInterface;

class SerializerSpec extends ObjectBehavior
{
    function let(NavigatorInterface $navigator, VisitorInterface $visitor, EncoderInterface $encoder)
    {
        $this->beConstructedWith($navigator, $visitor, $encoder);
    }

    function it_should_serialize_values(
        NavigatorInterface $navigator,
        VisitorInterface $visitor,
        EncoderInterface $encoder
    ) {
        // the navigator guides the visitor through the value graph
        $navigator->accept($navigator, $visitor, array('foo' => true))->willReturn();

        // the visitor builds a tree that can be encoded
        $visitor->getResult()->willReturn(array('foo' => '1'));

        // the encoder creates the final string
        $encoder->encode(array('foo' => '1'))->willReturn('foo=1');

        // together, this turns an object into a string
        $this->serialize(array('foo' => true))->shouldBe('foo=1');
    }
}
