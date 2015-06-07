<?php

namespace spec\Scato\Serializer\Url;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Common\PublicAccessor;
use Scato\Serializer\Common\SimpleObjectFactory;
use Scato\Serializer\Common\TypeProviderInterface;

class FromUrlVisitorSpec extends ObjectBehavior
{
    function let(TypeProviderInterface $typeProvider)
    {
        $this->beConstructedWith(new SimpleObjectFactory(), $typeProvider);
    }

    function it_should_be_an_object_to_array_visitor()
    {
        $this->shouldHaveType('Scato\Serializer\Common\MapToObjectVisitor');
    }

    function it_should_handle_an_object_with_a_string() {
        $object = Person::create(1, "Bryon Hetrick", true);

        $this->visitType(get_class($object));
        $this->visitArrayStart();
        $this->visitProperties();
        $this->visitArrayEnd();

        $this->getResult()->shouldBeLike($object);
    }

    function it_should_handle_an_object_with_a_number(TypeProviderInterface $typeProvider) {
        $object = Person::create(1, "Bryon Hetrick", true);

        $typeProvider->getType('spec\Scato\Serializer\Url\Person', 'personId')
            ->willReturn('integer');
        $typeProvider->getType(Argument::any(), Argument::any())
            ->willReturn(null);

        $this->visitType(get_class($object));
        $this->visitArrayStart();
        $this->visitProperties();
        $this->visitArrayEnd();

        $this->getResult()->getPersonId()->shouldBe(1);
    }

    function it_should_handle_an_object_with_a_boolean(TypeProviderInterface $typeProvider) {
        $object = Person::create(1, "Bryon Hetrick", true);

        $typeProvider->getType('spec\Scato\Serializer\Url\Person', 'registered')
            ->willReturn('boolean');
        $typeProvider->getType(Argument::any(), Argument::any())
            ->willReturn(null);

        $this->visitType(get_class($object));
        $this->visitArrayStart();
        $this->visitProperties();
        $this->visitArrayEnd();

        $this->getResult()->getRegistered()->shouldBe(true);
    }

    function it_should_handle_an_object_with_an_object(TypeProviderInterface $typeProvider) {
        $object = Person::create(1, "Bryon Hetrick", true);
        $object->address = Address::create('Dam', '1', 'Amsterdam');

        $typeProvider->getType('spec\Scato\Serializer\Url\Person', 'address')
            ->willReturn('spec\Scato\Serializer\Url\Address');
        $typeProvider->getType(Argument::any(), Argument::any())
            ->willReturn(null);

        $this->visitType(get_class($object));
        $this->visitArrayStart();
        $this->visitProperties();
        $this->visitAddress();
        $this->visitArrayEnd();

        $this->getResult()->shouldBeLike($object);
    }

    function it_should_handle_an_object_with_an_array(TypeProviderInterface $typeProvider) {
        $object = Person::create(1, "Bryon Hetrick", true);
        $object->phoneNumbers[] = PhoneNumber::create('Home', '0201234567');
        $object->phoneNumbers[] = PhoneNumber::create('Mobile', '0612345678');

        $typeProvider->getType('spec\Scato\Serializer\Url\Person', 'phoneNumbers')
            ->willReturn('spec\Scato\Serializer\Url\PhoneNumber[]');
        $typeProvider->getType(Argument::any(), Argument::any())
            ->willReturn(null);

        $this->visitType(get_class($object));
        $this->visitArrayStart();
        $this->visitProperties();
        $this->visitPhoneNumbers();
        $this->visitArrayEnd();

        $this->getResult()->shouldBeLike($object);
    }

    private function visitProperties()
    {
        $this->visitElementStart('personId');
        $this->visitString('1');
        $this->visitElementEnd('personId');
        $this->visitElementStart('name');
        $this->visitString('Bryon Hetrick');
        $this->visitElementEnd('name');
        $this->visitElementStart('registered');
        $this->visitString('1');
        $this->visitElementEnd('registered');
    }

    private function visitAddress()
    {
        $this->visitElementStart('address');
        $this->visitArrayStart();
        $this->visitElementStart('street');
        $this->visitString('Dam');
        $this->visitElementEnd('street');
        $this->visitElementStart('number');
        $this->visitString('1');
        $this->visitElementEnd('number');
        $this->visitElementStart('city');
        $this->visitString('Amsterdam');
        $this->visitElementEnd('city');
        $this->visitArrayEnd();
        $this->visitElementEnd('address');
    }

    private function visitPhoneNumbers()
    {
        $this->visitElementStart('phoneNumbers');
        $this->visitArrayStart();
        $this->visitElementStart('0');
        $this->visitArrayStart();
        $this->visitElementStart('name');
        $this->visitString('Home');
        $this->visitElementEnd('name');
        $this->visitElementStart('number');
        $this->visitString('0201234567');
        $this->visitElementEnd('number');
        $this->visitArrayEnd();
        $this->visitElementEnd('0');
        $this->visitElementStart('1');
        $this->visitArrayStart();
        $this->visitElementStart('name');
        $this->visitString('Mobile');
        $this->visitElementEnd('name');
        $this->visitElementStart('number');
        $this->visitString('0612345678');
        $this->visitElementEnd('number');
        $this->visitArrayEnd();
        $this->visitElementEnd('1');
        $this->visitArrayEnd();
        $this->visitElementEnd('phoneNumbers');
    }
}

class Person
{
    public $personId;
    public $name;
    public $registered;
    public $address;
    public $phoneNumbers = array();

    public static function create($personId, $name, $registered)
    {
        $object = new self();

        $object->personId = $personId;
        $object->name = $name;
        $object->registered = $registered;

        return $object;
    }

    public function getPersonId()
    {
        return $this->personId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRegistered()
    {
        return $this->registered;
    }
}

class Address
{
    public $street;
    public $number;
    public $city;

    public static function create($street, $number, $city)
    {
        $object = new self();

        $object->street = $street;
        $object->number = $number;
        $object->city = $city;

        return $object;
    }
}

class PhoneNumber
{
    public $name;
    public $number;

    public static function create($name, $number)
    {
        $object = new self();

        $object->name = $name;
        $object->number = $number;

        return $object;
    }
}
