<?php

namespace spec\Scato\Serializer\Common;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use stdClass;

class PublicAccessorSpec extends ObjectBehavior
{
    function it_should_be_an_object_accessor()
    {
        $this->shouldHaveType('Scato\Serializer\Core\ObjectAccessorInterface');
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

    function it_should_write_values()
    {
        $object = new stdClass();

        $this->setValue($object, 'foo', 'bar');

        $this->shouldHaveSet($object, 'foo', 'bar');
    }

    public function getMatchers()
    {
        return [
            'haveSet' => function ($subject, $object, $name, $value) {
                return $object->{$name} === $value;
            }
        ];
    }
}
