<?php

namespace spec\Scato\Serializer\Xml;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class XmlDeserializerFactorySpec extends ObjectBehavior
{
    function it_should_be_a_deserializer_factory()
    {
        $this->shouldHaveType('Scato\Serializer\Core\AbstractDeserializerFactory');
    }

    function it_should_create_a_deserializer()
    {
        $this->createDeserializer()->shouldHaveType('Scato\Serializer\Core\Deserializer');
    }

    function it_should_create_an_xml_deserializer()
    {
        $xml = "<?xml version=\"1.0\"?>\n"
            . "<root><personId>1</personId><name>Bryon Hetrick</name><registered>true</registered></root>\n";

        $object = Person2::create(1, "Bryon Hetrick", true);

        $this->createDeserializer()
            ->deserialize($xml, get_class($object))
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
