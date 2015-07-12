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

    function it_should_be_a_deserialize_visitor()
    {
        $this->shouldHaveType('Scato\Serializer\Common\DeserializeVisitor');
    }

    function it_should_handle_a_number()
    {
        $this->visitType(Type::fromString('integer'));
        $this->visitValue('1');

        $this->getResult()->shouldBe(1);
    }

    function it_should_handle_a_boolean()
    {
        $this->visitType(Type::fromString('boolean'));
        $this->visitValue('1');

        $this->getResult()->shouldBe(true);
    }
}
