<?php

namespace spec\Scato\Serializer\Php;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Common\TypeProviderInterface;
use Scato\Serializer\Core\Type;

class ArrayTypeProviderDecoratorSpec extends ObjectBehavior
{
    function let(TypeProviderInterface $parent)
    {
        $this->beConstructedWith($parent);
    }

    function it_should_be_a_type_provider()
    {
        $this->shouldHaveType('Scato\Serializer\Common\TypeProviderInterface');
    }

    function it_should_pass_along_types_for_properties(TypeProviderInterface $parent)
    {
        $parent->getType(Type::fromString('Foo'), 'bar')->willReturn(Type::fromString('string'));

        $this->getType(Type::fromString('Foo'), 'bar')->shouldBeLike(Type::fromString('string'));
    }

    function it_should_determine_array_types_by_itself()
    {
        $this->getType(Type::fromString('string[]'), 'bar')->shouldBeLike(Type::fromString('string'));
    }
}
