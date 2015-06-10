<?php

namespace spec\Scato\Serializer\Xml;

use DOMDocument;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class XmlDecoderSpec extends ObjectBehavior
{
    function it_should_be_a_decoder()
    {
        $this->shouldHaveType('Scato\Serializer\Core\DecoderInterface');
    }

    function it_should_decode_an_empty_element()
    {
        $dom = new DOMDocument();
        $dom->appendChild($dom->createElement('foo'));

        $this->decode("<foo/>")->shouldHaveSameXmlAs($dom);
    }

    function it_should_decode_an_element_with_a_child()
    {
        $dom = new DOMDocument();
        $dom->appendChild($foo = $dom->createElement('foo'));
        $foo->appendChild($bar = $dom->createElement('bar'));
        $bar->appendChild($dom->createTextNode('baz'));

        $this->decode("<foo><bar>baz</bar></foo>")->shouldHaveSameXmlAs($dom);
    }

    function it_should_decode_an_element_with_an_attribute()
    {
        $dom = new DOMDocument();
        $dom->appendChild($foo = $dom->createElement('foo'));
        $foo->setAttribute('bar', 'baz');

        $this->decode("<foo bar=\"baz\"/>")->shouldHaveSameXmlAs($dom);
    }

    public function getMatchers()
    {
        return [
            'haveSameXmlAs' => function (DOMDocument $subject, DOMDocument $element) {
                return $subject->saveXml() === $element->saveXml();
            }
        ];
    }
}
