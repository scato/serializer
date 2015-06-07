<?php

namespace spec\Scato\Serializer\Url;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ToUrlVisitorSpec extends ObjectBehavior
{
    function it_should_be_an_object_to_array_visitor()
    {
        $this->shouldHaveType('Scato\Serializer\Common\ObjectToArrayVisitor');
    }

    function it_should_handle_null()
    {
        $this->visitNull();

        $this->getResult()->shouldBe('');
    }

    function it_should_handle_a_number()
    {
        $this->visitNumber(1);

        $this->getResult()->shouldBe('1');
    }

    function it_should_handle_a_boolean()
    {
        $this->visitBoolean(true);

        $this->getResult()->shouldBe('1');
    }
}
