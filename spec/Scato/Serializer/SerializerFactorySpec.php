<?php

namespace spec\Scato\Serializer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SerializerFactorySpec extends ObjectBehavior
{
    function it_should_create_a_json_serializer()
    {
        $object = new Person(1, "Bryon Hetrick", true);

        $this->createJsonSerializer()
            ->serialize($object)
            ->shouldBe('{"personId":1,"name":"Bryon Hetrick","registered":true}');
    }

    function it_should_create_a_json_deserializer()
    {
        $object = new Person(1, "Bryon Hetrick", true);

        $this->createJsonDeserializer()
            ->deserialize('{"personId":1,"name":"Bryon Hetrick","registered":true}', get_class($object))
            ->shouldBeLike($object);
    }

    function it_should_create_a_url_serializer()
    {
        $object = new Person(1, "Bryon Hetrick", true);

        $this->createUrlSerializer()
            ->serialize($object)
            ->shouldBe('personId=1&name=Bryon+Hetrick&registered=1');
    }

    function it_should_create_a_url_deserializer()
    {
        $object = new Person(1, "Bryon Hetrick", true);

        $this->createUrlDeserializer()
            ->deserialize('personId=1&name=Bryon+Hetrick&registered=1', get_class($object))
            ->shouldBeLike($object);
    }
}

class Person
{
    public $personId;
    public $name;
    public $registered;

    public function __construct($personId, $name, $registered)
    {
        $this->personId = $personId;
        $this->name = $name;
        $this->registered = $registered;
    }
}
