<?php

namespace spec\Scato\Serializer\Json;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JsonSerializerFactorySpec extends ObjectBehavior
{
    function it_should_be_a_serializer_factory()
    {
        $this->shouldHaveType('Scato\Serializer\Core\AbstractSerializerFactory');
    }

    function it_should_create_a_serializer()
    {
        $this->createSerializer()->shouldHaveType('Scato\Serializer\Core\Serializer');
    }

    function it_should_create_a_json_serializer()
    {
        $object = Person::create(1, "Bryon Hetrick", true);

        $this->createSerializer()
            ->serialize($object)
            ->shouldBe('{"personId":1,"name":"Bryon Hetrick","registered":true}');
    }
}

class Person
{
    public $personId;
    public $name;
    public $registered;

    public static function create($personId, $name, $registered)
    {
        $object = new self();

        $object->personId = $personId;
        $object->name = $name;
        $object->registered = $registered;

        return $object;
    }
}
