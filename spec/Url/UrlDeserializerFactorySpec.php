<?php

namespace spec\Scato\Serializer\Url;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UrlDeserializerFactorySpec extends ObjectBehavior
{
    function it_should_be_a_deserializer_factory()
    {
        $this->shouldHaveType('Scato\Serializer\Core\AbstractDeserializerFactory');
    }

    function it_should_create_a_deserializer()
    {
        $this->createDeserializer()->shouldHaveType('Scato\Serializer\Core\Deserializer');
    }

    function it_should_create_a_url_deserializer()
    {
        $object = Person2::create(1, "Bryon Hetrick", true);

        $this->createDeserializer()
            ->deserialize('personId=1&name=Bryon+Hetrick&registered=1', get_class($object))
            ->shouldBeLike($object);
    }
}

class Person2
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
