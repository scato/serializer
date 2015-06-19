<?php

namespace spec\Scato\Serializer\Core;

use LogicException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TypeSpec extends ObjectBehavior
{
    function it_should_be_converted_back_to_a_string()
    {
        $this->beConstructedThrough('fromString', array('Foo'));

        $this->toString()->shouldBe('Foo');
    }

    function it_should_be_mixed_by_default()
    {
        $this->beConstructedThrough('fromString', array());

        $this->toString()->shouldBe('mixed');
    }

    function it_should_use_mixed_for_unknown_types()
    {
        $this->beConstructedThrough('fromString', array(null));

        $this->toString()->shouldBe('mixed');
    }

    function it_should_recognize_class_types()
    {
        $this->beConstructedThrough('fromString', array('Foo'));

        $this->isClass()->shouldBe(true);
        $this->isArray()->shouldBe(false);
        $this->isInteger()->shouldBe(false);
        $this->isFloat()->shouldBe(false);
        $this->isBoolean()->shouldBe(false);

        $this->getArrayType()->toString()->shouldBe('Foo[]');
        $this->shouldThrow(new LogicException("Type 'Foo' is not an array type"))->duringGetElementType();
    }

    function it_should_recognize_integer_types()
    {
        $this->beConstructedThrough('fromString', array('int'));

        $this->isClass()->shouldBe(false);
        $this->isArray()->shouldBe(false);
        $this->isInteger()->shouldBe(true);
        $this->isFloat()->shouldBe(false);
        $this->isBoolean()->shouldBe(false);

        $this->getArrayType()->toString()->shouldBe('int[]');
        $this->shouldThrow(new LogicException("Type 'int' is not an array type"))->duringGetElementType();
    }

    function it_should_recognize_float_types()
    {
        $this->beConstructedThrough('fromString', array('float'));

        $this->isClass()->shouldBe(false);
        $this->isArray()->shouldBe(false);
        $this->isInteger()->shouldBe(false);
        $this->isFloat()->shouldBe(true);
        $this->isBoolean()->shouldBe(false);

        $this->getArrayType()->toString()->shouldBe('float[]');
        $this->shouldThrow(new LogicException("Type 'float' is not an array type"))->duringGetElementType();
    }

    function it_should_recognize_boolean_types()
    {
        $this->beConstructedThrough('fromString', array('bool'));

        $this->isClass()->shouldBe(false);
        $this->isArray()->shouldBe(false);
        $this->isInteger()->shouldBe(false);
        $this->isFloat()->shouldBe(false);
        $this->isBoolean()->shouldBe(true);

        $this->getArrayType()->toString()->shouldBe('bool[]');
        $this->shouldThrow(new LogicException("Type 'bool' is not an array type"))->duringGetElementType();
    }

    function it_should_recognize_the_primitive_array_type()
    {
        $this->beConstructedThrough('fromString', array('array'));

        $this->isClass()->shouldBe(false);
        $this->isArray()->shouldBe(true);
        $this->isInteger()->shouldBe(false);
        $this->isFloat()->shouldBe(false);
        $this->isBoolean()->shouldBe(false);

        $this->getArrayType()->toString()->shouldBe('array[]');
        $this->getElementType()->toString()->shouldBe('mixed');
    }

    function it_should_recognize_the_mixed_type()
    {
        $this->beConstructedThrough('fromString', array('mixed'));

        $this->isClass()->shouldBe(false);
        $this->isArray()->shouldBe(true);
        $this->isInteger()->shouldBe(false);
        $this->isFloat()->shouldBe(false);
        $this->isBoolean()->shouldBe(false);

        $this->getArrayType()->toString()->shouldBe('array');
        $this->getElementType()->toString()->shouldBe('mixed');
    }

    function it_should_recognize_array_types()
    {
        $this->beConstructedThrough('fromString', array('Foo[]'));

        $this->isClass()->shouldBe(false);
        $this->isArray()->shouldBe(true);
        $this->isInteger()->shouldBe(false);
        $this->isFloat()->shouldBe(false);
        $this->isBoolean()->shouldBe(false);

        $this->getArrayType()->toString()->shouldBe('Foo[][]');
        $this->getElementType()->toString()->shouldBe('Foo');
    }
}
