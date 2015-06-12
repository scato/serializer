<?php

namespace spec\Scato\Serializer\Url;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Common\ObjectFactoryInterface;
use Scato\Serializer\Core\Type;
use Scato\Serializer\Common\TypeProviderInterface;
use stdClass;

class FromUrlVisitorSpec extends ObjectBehavior
{
    function let(ObjectFactoryInterface $objectFactory, TypeProviderInterface $typeProvider)
    {
        $typeProvider->getType(Type::fromString('Person'), 'personId')->willReturn(Type::fromString('integer'));
        $typeProvider->getType(Type::fromString('Person'), 'registered')->willReturn(Type::fromString('boolean'));
        $typeProvider->getType(Type::fromString('Person'), 'address')->willReturn(Type::fromString('Address'));
        $typeProvider->getType(Type::fromString('Person'), 'phoneNumbers')->willReturn(Type::fromString('PhoneNumber[]'));
        $typeProvider->getType(Argument::any(), Argument::any())->willReturn(Type::fromString(null));

        $this->beConstructedWith($objectFactory, $typeProvider);
    }

    function it_should_be_an_map_to_object_visitor()
    {
        $this->shouldHaveType('Scato\Serializer\Common\DeserializeVisitor');
    }

    function it_should_handle_an_object_with_a_string(
        ObjectFactoryInterface $objectFactory,
        stdClass $object
    ) {
        $objectFactory->createObject(Type::fromString('Person'), Argument::is($this->getProperties()))->willReturn($object);

        $this->visitType(Type::fromString('Person'));
        $this->visitArrayStart();
        $this->visitProperties();
        $this->visitArrayEnd();

        $this->getResult()->shouldBeLike($object);
    }

    function it_should_handle_an_object_with_an_object(
        ObjectFactoryInterface $objectFactory,
        stdClass $object,
        stdClass $address
    ) {
        $extra = array('address' => $address);
        $objectFactory->createObject(Type::fromString('Person'), $this->getProperties() + $extra)->willReturn($object);
        $objectFactory->createObject(Type::fromString('Address'), $this->getAddress())->willReturn($address);

        $this->visitType(Type::fromString('Person'));
        $this->visitArrayStart();
        $this->visitProperties();
        $this->visitAddress();
        $this->visitArrayEnd();

        $this->getResult()->shouldBeLike($object);
    }

    function it_should_handle_an_object_with_an_array(
        ObjectFactoryInterface $objectFactory,
        stdClass $object,
        stdClass $homeNumber,
        stdClass $mobileNumber
    ) {
        $extra = array('phoneNumbers' => array($homeNumber, $mobileNumber));
        $objectFactory->createObject(Type::fromString('Person'), $this->getProperties() + $extra)->willReturn($object);
        $objectFactory->createObject(Type::fromString('PhoneNumber'), $this->getPhoneNumbers()[0])->willReturn($homeNumber);
        $objectFactory->createObject(Type::fromString('PhoneNumber'), $this->getPhoneNumbers()[1])->willReturn($mobileNumber);

        $this->visitType(Type::fromString('Person'));
        $this->visitArrayStart();
        $this->visitProperties();
        $this->visitPhoneNumbers();
        $this->visitArrayEnd();

        $this->getResult()->shouldBeLike($object);
    }

    private function visitProperties()
    {
        $this->visitElementStart('personId');
        $this->visitValue('1');
        $this->visitElementEnd('personId');
        $this->visitElementStart('name');
        $this->visitValue('Bryon Hetrick');
        $this->visitElementEnd('name');
        $this->visitElementStart('registered');
        $this->visitValue('1');
        $this->visitElementEnd('registered');
    }

    private function visitAddress()
    {
        $this->visitElementStart('address');
        $this->visitArrayStart();
        $this->visitElementStart('street');
        $this->visitValue('Dam');
        $this->visitElementEnd('street');
        $this->visitElementStart('number');
        $this->visitValue('1');
        $this->visitElementEnd('number');
        $this->visitElementStart('city');
        $this->visitValue('Amsterdam');
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
        $this->visitValue('Home');
        $this->visitElementEnd('name');
        $this->visitElementStart('number');
        $this->visitValue('0201234567');
        $this->visitElementEnd('number');
        $this->visitArrayEnd();
        $this->visitElementEnd('0');
        $this->visitElementStart('1');
        $this->visitArrayStart();
        $this->visitElementStart('name');
        $this->visitValue('Mobile');
        $this->visitElementEnd('name');
        $this->visitElementStart('number');
        $this->visitValue('0612345678');
        $this->visitElementEnd('number');
        $this->visitArrayEnd();
        $this->visitElementEnd('1');
        $this->visitArrayEnd();
        $this->visitElementEnd('phoneNumbers');
    }

    private function getProperties()
    {
        return array('personId' => 1, 'name' => 'Bryon Hetrick', 'registered' => true);
    }

    private function getAddress()
    {
        return array('street' => 'Dam', 'number' => '1', 'city' => 'Amsterdam');
    }

    private function getPhoneNumbers()
    {
        return array(
            array('name' => 'Home', 'number' => '0201234567'),
            array('name' => 'Mobile', 'number' => '0612345678')
        );
    }
}
