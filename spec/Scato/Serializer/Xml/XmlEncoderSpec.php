<?php

namespace spec\Scato\Serializer\Xml;

use DOMDocument;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class XmlEncoderSpec extends ObjectBehavior
{
    const XML = "<?xml version=\"1.0\"?>\n";

    function it_should_be_an_encoder()
    {
        $this->shouldHaveType('Scato\Serializer\Core\EncoderInterface');
    }

    function it_should_encode_an_empty_element()
    {
        $dom = new DOMDocument();
        $dom->appendChild($dom->createElement('foo'));

        $this->encode($dom)->shouldBe(self::XML . "<foo/>\n");
    }

    function it_should_encode_an_element_with_a_child()
    {
        $dom = new DOMDocument();
        $dom->appendChild($foo = $dom->createElement('foo'));
        $foo->appendChild($bar = $dom->createElement('bar'));
        $bar->appendChild($dom->createTextNode('baz'));

        $this->encode($dom)->shouldBe(self::XML . "<foo><bar>baz</bar></foo>\n");
    }

    function it_should_encode_an_element_with_an_attribute()
    {
        $dom = new DOMDocument();
        $dom->appendChild($foo = $dom->createElement('foo'));
        $foo->setAttribute('bar', 'baz');

        $this->encode($dom)->shouldBe(self::XML . "<foo bar=\"baz\"/>\n");
    }
}
