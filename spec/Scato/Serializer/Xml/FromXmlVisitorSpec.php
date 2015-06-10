<?php

namespace spec\Scato\Serializer\Xml;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Common\ObjectFactoryInterface;
use Scato\Serializer\Common\TypeProviderInterface;
use stdClass;

class FromXmlVisitorSpec extends ObjectBehavior
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

    function it_should_be_an_map_to_object_visitor()
    {
        $this->shouldHaveType('Scato\Serializer\Common\MapToObjectVisitor');
    }

    function it_should_handle_an_object_with_a_string(
        ObjectFactoryInterface $objectFactory,
        stdClass $object
    ) {
        $objectFactory->createObject('Person', Argument::is($this->getProperties()))->willReturn($object);

        $this->visitType('Person');
        $this->visitObjectStart('DOMDocument');
        $this->visitProperties();
        $this->visitObjectEnd('DOMDocument');

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
        $this->visitObjectStart('DOMDocument');
        $this->visitProperties();
        $this->visitAddress();
        $this->visitObjectEnd('DOMDocument');

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
        $this->visitObjectStart('DOMDocument');
        $this->visitProperties();
        $this->visitPhoneNumbers();
        $this->visitObjectEnd('DOMDocument');

        $this->getResult()->shouldBeLike($object);
    }

    private function visitProperties()
    {
        $this->visitPropertyStart('personId');
        $this->visitSingleString('1');
        $this->visitPropertyEnd('personId');
        $this->visitPropertyStart('name');
        $this->visitSingleString('Bryon Hetrick');
        $this->visitPropertyEnd('name');
        $this->visitPropertyStart('registered');
        $this->visitSingleString('true');
        $this->visitPropertyEnd('registered');
    }

    private function visitAddress()
    {
        $this->visitPropertyStart('address');
        $this->visitSingleObjectStart();
        $this->visitPropertyStart('street');
        $this->visitSingleString('Dam');
        $this->visitPropertyEnd('street');
        $this->visitPropertyStart('number');
        $this->visitSingleString('1');
        $this->visitPropertyEnd('number');
        $this->visitPropertyStart('city');
        $this->visitSingleString('Amsterdam');
        $this->visitPropertyEnd('city');
        $this->visitSingleObjectEnd();
        $this->visitPropertyEnd('address');
    }

    private function visitPhoneNumbers()
    {
        $this->visitPropertyStart('phoneNumbers');
        $this->visitSingleObjectStart();
        $this->visitPropertyStart('entry');
        $this->visitArrayStart();
        $this->visitElementStart(0);
        $this->visitObjectStart('DOMElement');
        $this->visitPropertyStart('name');
        $this->visitSingleString('Home');
        $this->visitPropertyEnd('name');
        $this->visitPropertyStart('number');
        $this->visitSingleString('0201234567');
        $this->visitPropertyEnd('number');
        $this->visitObjectEnd('DOMElement');
        $this->visitElementEnd(0);
        $this->visitElementStart(1);
        $this->visitObjectStart('DOMElement');
        $this->visitPropertyStart('name');
        $this->visitSingleString('Mobile');
        $this->visitPropertyEnd('name');
        $this->visitPropertyStart('number');
        $this->visitSingleString('0612345678');
        $this->visitPropertyEnd('number');
        $this->visitObjectEnd('DOMElement');
        $this->visitElementEnd(1);
        $this->visitArrayEnd();
        $this->visitPropertyEnd('entry');
        $this->visitSingleObjectEnd();
        $this->visitPropertyEnd('phoneNumbers');
    }

    private function visitSingleString($value)
    {
        $this->visitArrayStart();
        $this->visitElementStart(0);
        $this->visitString($value);
        $this->visitElementEnd(0);
        $this->visitArrayEnd();
    }

    private function visitSingleObjectStart()
    {
        $this->visitArrayStart();
        $this->visitElementStart(0);
        $this->visitObjectStart('DOMElement');
    }

    private function visitSingleObjectEnd()
    {
        $this->visitObjectEnd('DOMElement');
        $this->visitElementEnd(0);
        $this->visitArrayEnd();
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
