<?php

namespace spec\Scato\Serializer\Common;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Core\Type;

class ReflectionTypeProviderSpec extends ObjectBehavior
{
    function it_should_be_a_type_provider()
    {
        $this->shouldHaveType('Scato\Serializer\Common\TypeProviderInterface');
    }

    function it_should_not_find_a_type_for_unknown_properties()
    {
        $class = Type::fromString('spec\Scato\Serializer\Common\ExampleObject');

        $this->getType($class, 'foz')->shouldBeLike(Type::fromString(null));
    }

    function it_should_not_find_a_type_for_untyped_properties()
    {
        $class = Type::fromString('spec\Scato\Serializer\Common\ExampleObject');

        $this->getType($class, 'foo')->shouldBeLike(Type::fromString(null));
    }

    function it_should_provide_a_type_for_typed_properties()
    {
        $class = Type::fromString('spec\Scato\Serializer\Common\ExampleObject');

        $this->getType($class, 'bar')->shouldBeLike(Type::fromString('string'));
    }
}

class ExampleObject
{
    public $foo;

    /**
     * @var string
     */
    public $bar;
}
