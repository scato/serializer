<?php

namespace spec\Scato\Serializer\Common;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Common\ObjectFactoryInterface;
use Scato\Serializer\Common\TypeProviderInterface;
use stdClass;

class MapToObjectVisitorSpec extends ObjectBehavior
{
    function let(ObjectFactoryInterface $objectFactory, TypeProviderInterface $typeProvider)
    {
        $typeProvider->getType('Person', 'address')->willReturn('Address');
        $typeProvider->getType('Person', 'phoneNumbers')->willReturn('PhoneNumber[]');
        $typeProvider->getType(Argument::any(), Argument::any())->willReturn(null);

        $this->beConstructedWith($objectFactory, $typeProvider);
    }

    function it_should_be_a_typed_visitor()
    {
        $this->shouldHaveType('Scato\Serializer\Core\TypedVisitorInterface');
    }

    function it_should_not_handle_an_object_without_knowing_its_type(
        ObjectFactoryInterface $objectFactory,
        stdClass $object
    ) {
        $this->visitType(null);
        $this->visitObjectStart('stdClass');

        $this->shouldThrow(new InvalidArgumentException('Cannot create object because its type is unknown'))
            ->duringVisitObjectEnd('stdClass');
    }

    function it_should_handle_an_object_with_a_string(
        ObjectFactoryInterface $objectFactory,
        stdClass $object
    ) {
        $objectFactory->createObject('Person', $this->getProperties())->willReturn($object);

        $this->visitType('Person');
        $this->visitObjectStart('stdClass');
        $this->visitProperties();
        $this->visitObjectEnd('stdClass');

        $this->getResult()->shouldBeLike($object);
    }

    function it_should_handle_an_object_with_an_object(
        ObjectFactoryInterface $objectFactory,
        stdClass $object,
        stdClass $address
    ) {
        $extra = array('address' => $address);
        $objectFactory->createObject('Person', $this->getProperties() + $extra)->willReturn($object);
        $objectFactory->createObject('Address', $this->getAddress())->willReturn($address);

        $this->visitType('Person');
        $this->visitObjectStart('stdClass');
        $this->visitProperties();
        $this->visitAddress();
        $this->visitObjectEnd('stdClass');

        $this->getResult()->shouldBeLike($object);
    }

    function it_should_handle_an_object_with_an_array(
        ObjectFactoryInterface $objectFactory,
        stdClass $object,
        stdClass $homeNumber,
        stdClass $mobileNumber
    ) {
        $extra = array('phoneNumbers' => array($homeNumber, $mobileNumber));
        $objectFactory->createObject('Person', $this->getProperties() + $extra)->willReturn($object);
        $objectFactory->createObject('PhoneNumber', $this->getPhoneNumbers()[0])->willReturn($homeNumber);
        $objectFactory->createObject('PhoneNumber', $this->getPhoneNumbers()[1])->willReturn($mobileNumber);

        $this->visitType('Person');
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
