<?php

namespace spec\Scato\Serializer\Xml;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Scato\Serializer\Common\ObjectFactoryInterface;
use Scato\Serializer\Core\Type;
use Scato\Serializer\Common\TypeProviderInterface;
use stdClass;

class FromXmlVisitorSpec extends ObjectBehavior
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
        $this->visitSingleValue('1');
        $this->visitPropertyEnd('personId');
        $this->visitPropertyStart('name');
        $this->visitSingleValue('Bryon Hetrick');
        $this->visitPropertyEnd('name');
        $this->visitPropertyStart('registered');
        $this->visitSingleValue('true');
        $this->visitPropertyEnd('registered');
    }

    private function visitAddress()
    {
        $this->visitPropertyStart('address');
        $this->visitSingleObjectStart();
        $this->visitPropertyStart('street');
        $this->visitSingleValue('Dam');
        $this->visitPropertyEnd('street');
        $this->visitPropertyStart('number');
        $this->visitSingleValue('1');
        $this->visitPropertyEnd('number');
        $this->visitPropertyStart('city');
        $this->visitSingleValue('Amsterdam');
        $this->visitPropertyEnd('city');
        $this->visitSingleObjectEnd();
        $this->visitPropertyEnd('address');
    }

    private function visitPhoneNumbers()
    {
        $this->visitPropertyStart('phoneNumbers');
        $this->visitSingleObjectStart();
        $this->visitPropertyStart('entry');
        $this->visitObjectStart();
        $this->visitPropertyStart('name');
        $this->visitSingleValue('Home');
        $this->visitPropertyEnd('name');
        $this->visitPropertyStart('number');
        $this->visitSingleValue('0201234567');
        $this->visitPropertyEnd('number');
        $this->visitObjectEnd();
        $this->visitPropertyEnd('entry');
        $this->visitPropertyStart('entry');
        $this->visitObjectStart();
        $this->visitPropertyStart('name');
        $this->visitSingleValue('Mobile');
        $this->visitPropertyEnd('name');
        $this->visitPropertyStart('number');
        $this->visitSingleValue('0612345678');
        $this->visitPropertyEnd('number');
        $this->visitObjectEnd();
        $this->visitPropertyEnd('entry');
        $this->visitSingleObjectEnd();
        $this->visitPropertyEnd('phoneNumbers');
    }

    private function visitSingleValue($value)
    {
        $this->visitValue($value);
    }

    private function visitSingleObjectStart()
    {
        $this->visitObjectStart();
    }

    private function visitSingleObjectEnd()
    {
        $this->visitObjectEnd();
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
