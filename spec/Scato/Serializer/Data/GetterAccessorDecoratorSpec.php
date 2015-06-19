<?php

namespace spec\Scato\Serializer\Data;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Core\ObjectAccessorInterface;
use stdClass;

class GetterAccessorDecoratorSpec extends ObjectBehavior
{
    function let(ObjectAccessorInterface $parent)
    {
        $this->beConstructedWith($parent);
    }

    function it_should_be_a_decorator()
    {
        $this->shouldHaveType('Scato\Serializer\Core\ObjectAccessorInterface');
    }

    function it_should_count_getters_as_properties(ObjectAccessorInterface $parent)
    {
        $object = new Person();

        $parent->getNames($object)->willReturn(array());

        $this->getNames($object)->shouldBe(array('name'));
    }

    function it_should_also_find_properties_through_its_parent(ObjectAccessorInterface $parent)
    {
        $object = new stdClass();

        $parent->getNames($object)->willReturn(array('foo'));

        $this->getNames($object)->shouldBe(array('foo'));
    }

    function it_should_use_getters_when_available()
    {
        $object = new Person();
        $object->setName('Bob');

        $this->getValue($object, 'name')->shouldBe('Bob');
    }

    function it_should_get_values_through_its_parent_otherwise(ObjectAccessorInterface $parent)
    {
        $object = new stdClass();

        $parent->getValue($object, 'foo')->willReturn('bar');

        $this->getValue($object, 'foo')->shouldBe('bar');
    }
}

class Person
{
    private $name;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
