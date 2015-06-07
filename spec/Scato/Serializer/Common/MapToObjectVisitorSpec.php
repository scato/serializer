<?php

namespace spec\Scato\Serializer\Common;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Common\PublicAccessor;
use Scato\Serializer\Common\TypeProviderInterface;

class MapToObjectVisitorSpec extends ObjectBehavior
{
    function let(TypeProviderInterface $typeProvider)
    {
        $this->beConstructedWith(new PublicAccessor(), $typeProvider);
    }

    function it_should_be_a_typed_visitor()
    {
        $this->shouldHaveType('Scato\Serializer\Core\TypedVisitorInterface');
    }

    function it_should_handle_an_object_with_a_string() {
        $object = new Person(1, "Bryon Hetrick", true);

        $this->visitType(get_class($object));
        $this->visitObjectStart('stdClass');
        $this->visitProperties();
        $this->visitObjectEnd('stdClass');

        $this->getResult()->shouldBeLike($object);
    }

    function it_should_handle_an_object_with_an_object(TypeProviderInterface $typeProvider) {
        $object = new Person(1, "Bryon Hetrick", true);
        $object->address = new Address('Dam', '1', 'Amsterdam');

        $typeProvider->getType('spec\Scato\Serializer\Common\Person', 'address')
            ->willReturn('spec\Scato\Serializer\Common\Address');
        $typeProvider->getType(Argument::any(), Argument::any())
            ->willReturn(null);

        $this->visitType(get_class($object));
        $this->visitObjectStart('stdClass');
        $this->visitProperties();
        $this->visitAddress();
        $this->visitObjectEnd('stdClass');

        $this->getResult()->shouldBeLike($object);
    }

    function it_should_handle_an_object_with_an_array(TypeProviderInterface $typeProvider) {
        $object = new Person(1, "Bryon Hetrick", true);
        $object->phoneNumbers[] = new PhoneNumber('Home', '0201234567');
        $object->phoneNumbers[] = new PhoneNumber('Mobile', '0612345678');

        $typeProvider->getType('spec\Scato\Serializer\Common\Person', 'phoneNumbers')
            ->willReturn('spec\Scato\Serializer\Common\PhoneNumber[]');
        $typeProvider->getType(Argument::any(), Argument::any())
            ->willReturn(null);

        $this->visitType(get_class($object));
        $this->visitObjectStart('stdClass');
        $this->visitProperties();
        $this->visitPhoneNumbers();
        $this->visitObjectEnd('stdClass');

        $this->getResult()->shouldBeLike($object);
    }

    private function visitProperties()
    {
        $this->visitPropertyStart('personId');
        $this->visitNumber(1);
        $this->visitPropertyEnd('personId');
        $this->visitPropertyStart('name');
        $this->visitString('Bryon Hetrick');
        $this->visitPropertyEnd('name');
        $this->visitPropertyStart('registered');
        $this->visitBoolean(true);
        $this->visitPropertyEnd('registered');
    }

    private function visitAddress()
    {
        $this->visitPropertyStart('address');
        $this->visitObjectStart('stdClass');
        $this->visitPropertyStart('street');
        $this->visitString('Dam');
        $this->visitPropertyEnd('street');
        $this->visitPropertyStart('number');
        $this->visitString('1');
        $this->visitPropertyEnd('number');
        $this->visitPropertyStart('city');
        $this->visitString('Amsterdam');
        $this->visitPropertyEnd('city');
        $this->visitObjectEnd('stdClass');
        $this->visitPropertyEnd('address');
    }

    private function visitPhoneNumbers()
    {
        $this->visitPropertyStart('phoneNumbers');
        $this->visitArrayStart();
        $this->visitElementStart(0);
        $this->visitObjectStart('stdClass');
        $this->visitPropertyStart('name');
        $this->visitString('Home');
        $this->visitPropertyEnd('name');
        $this->visitPropertyStart('number');
        $this->visitString('0201234567');
        $this->visitPropertyEnd('number');
        $this->visitObjectEnd('stdClass');
        $this->visitElementEnd(0);
        $this->visitElementStart(1);
        $this->visitObjectStart('stdClass');
        $this->visitPropertyStart('name');
        $this->visitString('Mobile');
        $this->visitPropertyEnd('name');
        $this->visitPropertyStart('number');
        $this->visitString('0612345678');
        $this->visitPropertyEnd('number');
        $this->visitObjectEnd('stdClass');
        $this->visitElementEnd(1);
        $this->visitArrayEnd();
        $this->visitPropertyEnd('phoneNumbers');
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
