<?php

namespace spec\Scato\Serializer\Data;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DataMapperFactorySpec extends ObjectBehavior
{
    function it_should_create_a_mapper()
    {
        $this->createMapper()->shouldHaveType('Scato\Serializer\Data\Mapper');
    }

    function it_should_create_a_data_mapper()
    {
        $data = array(
            'personId' => 1,
            'name' => 'Bryon Hetrick',
            'registered' => true
        );

        $object = Person::create(1, "Bryon Hetrick", true);

        $this->createMapper()
            ->map($data, get_class($object))
            ->shouldBeLike($object);

        $this->createMapper()
            ->map($object, 'array')
            ->shouldBe($data);
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
