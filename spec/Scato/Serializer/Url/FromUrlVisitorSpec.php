<?php

namespace spec\Scato\Serializer\Url;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Common\PublicAccessor;
use Scato\Serializer\Common\TypeProviderInterface;

class FromUrlVisitorSpec extends ObjectBehavior
{
    function let(TypeProviderInterface $typeProvider)
    {
        $this->beConstructedWith(new PublicAccessor(), $typeProvider);
    }

    function it_should_be_an_object_to_array_visitor()
    {
        $this->shouldHaveType('Scato\Serializer\Common\MapToObjectVisitor');
    }

    function it_should_handle_an_object_with_a_string() {
        $object = new Person(1, "Bryon Hetrick", true);

        $this->visitType(get_class($object));
        $this->visitArrayStart();
        $this->visitProperties();
        $this->visitArrayEnd();

        $this->getResult()->shouldBeLike($object);
    }

    function it_should_handle_an_object_with_a_number(TypeProviderInterface $typeProvider) {
        $object = new Person(1, "Bryon Hetrick", true);

        $typeOfPerson = Argument::type('spec\Scato\Serializer\Url\Person');

        $typeProvider->getType($typeOfPerson, 'personId')->willReturn('integer');
        $typeProvider->getType(Argument::any(), Argument::any())->willReturn(null);

        $this->visitType(get_class($object));
        $this->visitArrayStart();
        $this->visitProperties();
        $this->visitArrayEnd();

        $this->getResult()->getPersonId()->shouldBe(1);
    }

    function it_should_handle_an_object_with_a_boolean(TypeProviderInterface $typeProvider) {
        $object = new Person(1, "Bryon Hetrick", true);

        $typeOfPerson = Argument::type('spec\Scato\Serializer\Url\Person');

        $typeProvider->getType($typeOfPerson, 'registered')->willReturn('boolean');
        $typeProvider->getType(Argument::any(), Argument::any())->willReturn(null);

        $this->visitType(get_class($object));
        $this->visitArrayStart();
        $this->visitProperties();
        $this->visitArrayEnd();

        $this->getResult()->getRegistered()->shouldBe(true);
    }

    function it_should_handle_an_object_with_an_object(TypeProviderInterface $typeProvider) {
        $object = new Person(1, "Bryon Hetrick", true);
        $object->address = new Address('Dam', '1', 'Amsterdam');

        $typeOfPerson = Argument::type('spec\Scato\Serializer\Url\Person');

        $typeProvider->getType($typeOfPerson, 'address')->willReturn('spec\Scato\Serializer\Url\Address');
        $typeProvider->getType(Argument::any(), Argument::any())->willReturn(null);

        $this->visitType(get_class($object));
        $this->visitArrayStart();
        $this->visitProperties();
        $this->visitAddress();
        $this->visitArrayEnd();

        $this->getResult()->shouldBeLike($object);
    }

    function it_should_handle_an_object_with_an_array(TypeProviderInterface $typeProvider) {
        $object = new Person(1, "Bryon Hetrick", true);
        $object->phoneNumbers[] = new PhoneNumber('Home', '0201234567');
        $object->phoneNumbers[] = new PhoneNumber('Mobile', '0612345678');

        $typeOfPerson = Argument::type('spec\Scato\Serializer\Url\Person');

        $typeProvider->getType($typeOfPerson, 'phoneNumbers')->willReturn('spec\Scato\Serializer\Url\PhoneNumber[]');
        $typeProvider->getType(Argument::any(), Argument::any())->willReturn(null);

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

    public function __construct($personId, $name, $registered)
    {
        $this->personId = $personId;
        $this->name = $name;
        $this->registered = $registered;
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

    public function __construct($street, $number, $city)
    {
        $this->street = $street;
        $this->number = $number;
        $this->city = $city;
    }
}

class PhoneNumber
{
    public $name;
    public $number;

    public function __construct($name, $number)
    {
        $this->name = $name;
        $this->number = $number;
    }
}
