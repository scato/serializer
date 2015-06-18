<?php

namespace spec\Scato\Serializer\Php;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Core\Navigator;
use Scato\Serializer\Core\Type;
use Scato\Serializer\Core\TypedVisitorInterface;

class MapperSpec extends ObjectBehavior
{
    function let(Navigator $navigator, TypedVisitorInterface $visitor)
    {
        $this->beConstructedWith($navigator, $visitor);
    }

    function it_should_deserialize_values(
        Navigator $navigator,
        TypedVisitorInterface $visitor
    ) {
        // the visitor is told which type the root has
        $visitor->visitType(Type::fromString('boolean[]'))->willReturn();

        // the navigator guides the visitor through the tree
        $navigator->accept($visitor, array('foo' => '1'))->willReturn();

        // the visitor builds the final graph
        $visitor->getResult()->willReturn(array('foo' => true));

        // together, this turns a tree back into a value
        $this->map(array('foo' => '1'), 'boolean[]')->shouldBe(array('foo' => true));
    }
}