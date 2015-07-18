<?php

namespace spec\Scato\Serializer\Url;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ToUrlVisitorSpec extends ObjectBehavior
{
    function it_should_be_a_serializer_visitor()
    {
        $this->shouldHaveType('Scato\Serializer\Navigation\SerializeVisitor');
    }

    function it_should_handle_null()
    {
        $this->visitValue(null);

        $this->getResult()->shouldBe('');
    }

    function it_should_handle_a_number()
    {
        $this->visitValue(1);

        $this->getResult()->shouldBe('1');
    }

    function it_should_handle_a_boolean()
    {
        $this->visitValue(true);

        $this->getResult()->shouldBe('1');
    }
}
