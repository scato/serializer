<?php

namespace spec\Scato\Serializer\ObjectAccess;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use stdClass;

class SimpleAccessorSpec extends ObjectBehavior
{
    function it_should_be_an_object_accessor()
    {
        $this->shouldHaveType('Scato\Serializer\Navigation\ObjectAccessorInterface');
    }

    function it_should_find_names()
    {
        $object = new stdClass();
        $object->foo = 'bar';

        $this->getNames($object)->shouldBe(array('foo'));
    }

    function it_should_read_values()
    {
        $object = new stdClass();
        $object->foo = 'bar';

        $this->getValue($object, 'foo')->shouldBe('bar');
    }

    function it_should_find_properties_with_dashes()
    {
        $array = ['foo-bar' => 'foobar'];
        $object = (object) $array;

        $this->getNames($object)->shouldBe(array('foo-bar'));
    }

    function it_should_read_properties_with_dashes()
    {
        $array = ['foo-bar' => 'foobar'];
        $object = (object) $array;

        $this->getValue($object, 'foo-bar')->shouldBe('foobar');
    }
}
