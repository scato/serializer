<?php

namespace spec\Scato\Serializer\Common;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Common\ObjectFactoryInterface;
use Scato\Serializer\Core\Type;
use Scato\Serializer\Common\TypeProviderInterface;
use stdClass;

class DeserializeVisitorSpec extends ObjectBehavior
{
    function let(ObjectFactoryInterface $objectFactory, TypeProviderInterface $typeProvider)
    {
        $typeProvider->getType(Type::fromString('Person'), 'address')->willReturn(Type::fromString('Address'));
        $typeProvider->getType(Type::fromString('Person'), 'phoneNumbers')->willReturn(Type::fromString('PhoneNumber[]'));
        $typeProvider->getType(Argument::any(), Argument::any())->willReturn(Type::fromString(null));

        $this->beConstructedWith($objectFactory, $typeProvider);
    }

    function it_should_be_a_typed_visitor()
    {
        $this->shouldHaveType('Scato\Serializer\Core\TypedVisitorInterface');
    }

    function it_should_handle_an_object_with_a_string(
        ObjectFactoryInterface $objectFactory,
        stdClass $object
    ) {
        $objectFactory->createObject(Type::fromString('Person'), $this->getProperties())->willReturn($object);

        $this->visitType(Type::fromString('Person'));
        $this->visitObjectStart();
        $this->visitProperties();
        $this->visitObjectEnd();

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
        $this->visitObjectStart();
        $this->visitProperties();
        $this->visitAddress();
        $this->visitObjectEnd();

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
        $this->visitObjectStart();
        $this->visitProperties();
        $this->visitPhoneNumbers();
        $this->visitObjectEnd();

        $this->getResult()->shouldBeLike($object);
    }

    private function visitProperties()
    {
        $this->visitPropertyStart('personId');
        $this->visitValue(1);
        $this->visitPropertyEnd('personId');
        $this->visitPropertyStart('name');
        $this->visitValue('Bryon Hetrick');
        $this->visitPropertyEnd('name');
        $this->visitPropertyStart('registered');
        $this->visitValue(true);
        $this->visitPropertyEnd('registered');
    }

    private function visitAddress()
    {
        $this->visitPropertyStart('address');
        $this->visitObjectStart();
        $this->visitPropertyStart('street');
        $this->visitValue('Dam');
        $this->visitPropertyEnd('street');
        $this->visitPropertyStart('number');
        $this->visitValue('1');
        $this->visitPropertyEnd('number');
        $this->visitPropertyStart('city');
        $this->visitValue('Amsterdam');
        $this->visitPropertyEnd('city');
        $this->visitObjectEnd();
        $this->visitPropertyEnd('address');
    }

    private function visitPhoneNumbers()
    {
        $this->visitPropertyStart('phoneNumbers');
        $this->visitArrayStart();
        $this->visitElementStart(0);
        $this->visitObjectStart();
        $this->visitPropertyStart('name');
        $this->visitValue('Home');
        $this->visitPropertyEnd('name');
        $this->visitPropertyStart('number');
        $this->visitValue('0201234567');
        $this->visitPropertyEnd('number');
        $this->visitObjectEnd();
        $this->visitElementEnd(0);
        $this->visitElementStart(1);
        $this->visitObjectStart();
        $this->visitPropertyStart('name');
        $this->visitValue('Mobile');
        $this->visitPropertyEnd('name');
        $this->visitPropertyStart('number');
        $this->visitValue('0612345678');
        $this->visitPropertyEnd('number');
        $this->visitObjectEnd();
        $this->visitElementEnd(1);
        $this->visitArrayEnd();
        $this->visitPropertyEnd('phoneNumbers');
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
