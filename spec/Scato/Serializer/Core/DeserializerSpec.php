<?php

namespace spec\Scato\Serializer\Core;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Core\DecoderInterface;
use Scato\Serializer\Core\Navigator;
use Scato\Serializer\Core\Type;
use Scato\Serializer\Core\TypedVisitorInterface;

class DeserializerSpec extends ObjectBehavior
{
    function let(Navigator $navigator, TypedVisitorInterface $visitor, DecoderInterface $decoder)
    {
        $this->beConstructedWith($navigator, $visitor, $decoder);
    }

    function it_should_deserialize_values(
        Navigator $navigator,
        TypedVisitorInterface $visitor,
        DecoderInterface $decoder
    ) {
        // the decoder turns the string back into a tree
        $decoder->decode('foo=1')->willReturn(array('foo' => '1'));

        // the visitor is told which type the root has
        $visitor->visitType(Type::fromString('boolean[]'))->willReturn();

        // the navigator guides the visitor through the tree
        $navigator->accept($visitor, array('foo' => '1'))->willReturn();

        // the visitor builds the final graph
        $visitor->getResult()->willReturn(array('foo' => true));

        // together, this turns a string back into a value
        $this->deserialize('foo=1', 'boolean[]')->shouldBe(array('foo' => true));
    }
}
