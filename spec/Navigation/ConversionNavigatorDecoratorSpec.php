<?php

namespace spec\Scato\Serializer\Navigation;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Core\NavigatorInterface;
use Scato\Serializer\Core\VisitorInterface;
use Scato\Serializer\Navigation\SerializationConverterInterface;

class ConversionNavigatorDecoratorSpec extends ObjectBehavior
{
    function let(NavigatorInterface $navigator, SerializationConverterInterface $converter)
    {
        $this->beConstructedWith($navigator, $converter);
    }

    function it_should_be_a_navigator()
    {
        $this->shouldHaveType('Scato\Serializer\Core\NavigatorInterface');
    }

    function it_should_apply_the_converter_before_passing_the_value_to_its_inner_navigator(
        NavigatorInterface $navigator,
        VisitorInterface $visitor,
        SerializationConverterInterface $converter
    ) {
        $converter->convert('foo')->willReturn('foobar');

        $navigator->accept($navigator, $visitor, 'foobar')->shouldBeCalled();

        $this->accept($navigator, $visitor, 'foo');
    }
}
