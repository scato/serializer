<?php

namespace spec\Scato\Serializer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SerializerFactorySpec extends ObjectBehavior
{
    function it_should_create_a_json_serializer()
    {
        $object = Person::create(1, "Bryon Hetrick", true);

        $this->createJsonSerializer()
            ->serialize($object)
            ->shouldBe('{"personId":1,"name":"Bryon Hetrick","registered":true}');
    }

    function it_should_create_a_json_deserializer()
    {
        $object = Person::create(1, "Bryon Hetrick", true);

        $this->createJsonDeserializer()
            ->deserialize('{"personId":1,"name":"Bryon Hetrick","registered":true}', get_class($object))
            ->shouldBeLike($object);
    }

    function it_should_create_a_url_serializer()
    {
        $object = Person::create(1, "Bryon Hetrick", true);

        $this->createUrlSerializer()
            ->serialize($object)
            ->shouldBe('personId=1&name=Bryon+Hetrick&registered=1');
    }

    function it_should_create_a_url_deserializer()
    {
        $object = Person::create(1, "Bryon Hetrick", true);

        $this->createUrlDeserializer()
            ->deserialize('personId=1&name=Bryon+Hetrick&registered=1', get_class($object))
            ->shouldBeLike($object);
    }

    function it_should_create_an_xml_serializer()
    {
        $object = Person::create(1, "Bryon Hetrick", true);

        $xml = "<?xml version=\"1.0\"?>\n"
            . "<root><personId>1</personId><name>Bryon Hetrick</name><registered>true</registered></root>\n";

        $this->createXmlSerializer()
            ->serialize($object)
            ->shouldBe($xml);
    }

    function it_should_create_an_xml_deserializer()
    {
        $xml = "<?xml version=\"1.0\"?>\n"
            . "<root><personId>1</personId><name>Bryon Hetrick</name><registered>true</registered></root>\n";

        $object = Person::create(1, "Bryon Hetrick", true);

        $this->createXmlDeserializer()
            ->deserialize($xml, get_class($object))
            ->shouldBeLike($object);
    }

    function it_should_create_a_data_mapper()
    {
        $data = array(
            'personId' => 1,
            'name' => 'Bryon Hetrick',
            'registered' => true
        );

        $object = Person::create(1, "Bryon Hetrick", true);

        $this->createDataMapper()
            ->map($data, get_class($object))
            ->shouldBeLike($object);

        $this->createDataMapper()
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
