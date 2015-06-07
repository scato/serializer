<?php

namespace spec\Scato\Serializer\Url;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Common\ObjectFactoryInterface;
use Scato\Serializer\Common\TypeProviderInterface;
use stdClass;

class FromUrlVisitorSpec extends ObjectBehavior
{
    function let(ObjectFactoryInterface $objectFactory, TypeProviderInterface $typeProvider)
    {
        $typeProvider->getType('Person', 'personId')->willReturn('integer');
        $typeProvider->getType('Person', 'registered')->willReturn('boolean');
        $typeProvider->getType('Person', 'address')->willReturn('Address');
        $typeProvider->getType('Person', 'phoneNumbers')->willReturn('PhoneNumber[]');
        $typeProvider->getType(Argument::any(), Argument::any())->willReturn(null);

        $this->beConstructedWith($objectFactory, $typeProvider);
    }

    function it_should_be_an_object_to_array_visitor()
    {
        $this->shouldHaveType('Scato\Serializer\Common\MapToObjectVisitor');
    }

    function it_should_handle_an_object_with_a_string(
        ObjectFactoryInterface $objectFactory,
        TypeProviderInterface $typeProvider,
        stdClass $object
    ) {
        $objectFactory->createObject('Person', Argument::is($this->getProperties()))->willReturn($object);

        $this->visitType('Person');
        $this->visitArrayStart();
        $this->visitProperties();
        $this->visitArrayEnd();

        $this->getResult()->shouldBeLike($object);
    }

    function it_should_handle_an_object_with_an_object(
        ObjectFactoryInterface $objectFactory,
        TypeProviderInterface $typeProvider,
        stdClass $object,
        stdClass $address
    ) {
        $extra = array('address' => $address);
        $objectFactory->createObject('Person', $this->getProperties() + $extra)->willReturn($object);
        $objectFactory->createObject('Address', $this->getAddress())->willReturn($address);

        $this->visitType('Person');
        $this->visitArrayStart();
        $this->visitProperties();
        $this->visitAddress();
        $this->visitArrayEnd();

        $this->getResult()->shouldBeLike($object);
    }

    function it_should_handle_an_object_with_an_array(
        ObjectFactoryInterface $objectFactory,
        TypeProviderInterface $typeProvider,
        stdClass $object,
        stdClass $homeNumber,
        stdClass $mobileNumber
    ) {
        $extra = array('phoneNumbers' => array($homeNumber, $mobileNumber));
        $objectFactory->createObject('Person', $this->getProperties() + $extra)->willReturn($object);
        $objectFactory->createObject('PhoneNumber', $this->getPhoneNumbers()[0])->willReturn($homeNumber);
        $objectFactory->createObject('PhoneNumber', $this->getPhoneNumbers()[1])->willReturn($mobileNumber);

        $this->visitType('Person');
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
