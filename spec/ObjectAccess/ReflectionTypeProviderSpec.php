<?php

namespace spec\Scato\Serializer\ObjectAccess;

use PhpSpec\ObjectBehavior;
use Scato\Serializer\Core\Type;

class ReflectionTypeProviderSpec extends ObjectBehavior
{
    const EXAMPLE_CLASS = '\spec\Scato\Serializer\ObjectAccess\ExampleObject';

    function it_should_be_a_type_provider()
    {
        $this->shouldHaveType('Scato\Serializer\Navigation\TypeProviderInterface');
    }

    function it_should_not_find_a_type_for_unknown_properties()
    {
        $class = Type::fromString(self::EXAMPLE_CLASS);

        $this->getType($class, 'foz')->shouldBeLike(Type::fromString(null));
    }

    function it_should_not_find_a_type_for_untyped_properties()
    {
        $class = Type::fromString(self::EXAMPLE_CLASS);

        $this->getType($class, 'foo')->shouldBeLike(Type::fromString(null));
    }

    function it_should_provide_a_type_for_typed_properties()
    {
        $class = Type::fromString(self::EXAMPLE_CLASS);

        $this->getType($class, 'bar')->shouldBeLike(Type::fromString(self::EXAMPLE_CLASS));
    }
}

class ExampleObject
{
    public $foo;

    /**
     * @var ExampleObject
     */
    public $bar;
}
