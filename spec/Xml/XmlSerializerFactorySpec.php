<?php

namespace spec\Scato\Serializer\Xml;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class XmlSerializerFactorySpec extends ObjectBehavior
{
    function it_should_be_a_serializer_factory()
    {
        $this->shouldHaveType('Scato\Serializer\Core\AbstractSerializerFactory');
    }

    function it_should_create_a_serializer()
    {
        $this->createSerializer()->shouldHaveType('Scato\Serializer\Core\Serializer');
    }

    function it_should_create_an_xml_serializer()
    {
        $object = Person::create(1, "Bryon Hetrick", true);

        $xml = "<?xml version=\"1.0\"?>\n"
            . "<root><personId>1</personId><name>Bryon Hetrick</name><registered>true</registered></root>\n";

        $this->createSerializer()
            ->serialize($object)
            ->shouldBe($xml);
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
