<?php

namespace spec\Scato\Serializer\Common;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReflectionTypeProviderSpec extends ObjectBehavior
{
    function it_should_be_a_type_provider()
    {
        $this->shouldHaveType('Scato\Serializer\Common\TypeProviderInterface');
    }

    function it_should_not_find_a_type_for_unknown_properties()
    {
        $this->getType('spec\Scato\Serializer\Common\ExampleObject', 'foz')->shouldBe(null);
    }

    function it_should_not_find_a_type_for_untyped_properties()
    {
        $this->getType('spec\Scato\Serializer\Common\ExampleObject', 'foo')->shouldBe(null);
    }

    function it_should_provide_a_type_for_typed_properties()
    {
        $this->getType('spec\Scato\Serializer\Common\ExampleObject', 'bar')->shouldBe('string');
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
