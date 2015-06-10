<?php

namespace spec\Scato\Serializer\Xml;

use DOMDocument;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ToXmlVisitorSpec extends ObjectBehavior
{
    function it_should_be_an_object_to_array_visitor()
    {
        $this->shouldHaveType('Scato\Serializer\Common\ObjectToArrayVisitor');
    }

    function it_should_handle_an_empty_object() {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));

        $this->visitObjectStart('ExampleObject');
        $this->visitObjectEnd('ExampleObject');

        $this->getResult()->shouldHaveSameXmlAs($dom);
    }

    function it_should_handle_an_object_with_a_string() {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));
        $root->appendChild($foo = $dom->createElement('foo'));
        $foo->appendChild($dom->createTextNode('bar'));

        $this->visitObjectStart('ExampleObject');
        $this->visitPropertyStart('foo');
        $this->visitString('bar');
        $this->visitPropertyEnd('foo');
        $this->visitObjectEnd('ExampleObject');

        $this->getResult()->shouldHaveSameXmlAs($dom);
    }

    function it_should_handle_an_object_with_an_array() {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));
        $root->appendChild($foo = $dom->createElement('foo'));

        $foo->appendChild($entry = $dom->createElement('entry'));
        $entry->appendChild($dom->createTextNode('bar'));

        $foo->appendChild($entry = $dom->createElement('entry'));
        $entry->appendChild($dom->createTextNode('baz'));

        $this->visitObjectStart('ExampleObject');
        $this->visitPropertyStart('foo');
        $this->visitArrayStart();
        $this->visitElementStart(0);
        $this->visitString('bar');
        $this->visitElementEnd(0);
        $this->visitElementStart(1);
        $this->visitString('baz');
        $this->visitElementEnd(1);
        $this->visitArrayEnd();
        $this->visitPropertyEnd('foo');
        $this->visitObjectEnd('ExampleObject');

        $this->getResult()->shouldHaveSameXmlAs($dom);
    }

    function it_should_handle_an_object_with_an_object() {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));
        $root->appendChild($foo = $dom->createElement('foo'));
        $foo->appendChild($bar = $dom->createElement('bar'));
        $bar->appendChild($dom->createTextNode('baz'));
        $foo->appendChild($foz = $dom->createElement('foz'));
        $foz->appendChild($dom->createTextNode('baz'));

        $this->visitObjectStart('ExampleObject');
        $this->visitPropertyStart('foo');
        $this->visitObjectStart('ExampleChild');
        $this->visitPropertyStart('bar');
        $this->visitString('baz');
        $this->visitPropertyEnd('bar');
        $this->visitPropertyStart('foz');
        $this->visitString('baz');
        $this->visitPropertyEnd('foz');
        $this->visitObjectEnd('ExampleChild');
        $this->visitPropertyEnd('foo');
        $this->visitObjectEnd('ExampleObject');

        $this->getResult()->shouldHaveSameXmlAs($dom);
    }

    function it_should_handle_null()
    {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));
        $root->appendChild($foo = $dom->createElement('foo'));
        $foo->appendChild($dom->createTextNode(''));

        $this->visitObjectStart('ExampleObject');
        $this->visitPropertyStart('foo');
        $this->visitNull();
        $this->visitPropertyEnd('foo');
        $this->visitObjectEnd('ExampleObject');

        $this->getResult()->shouldHaveSameXmlAs($dom);
    }

    function it_should_handle_a_number()
    {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));
        $root->appendChild($foo = $dom->createElement('foo'));
        $foo->appendChild($dom->createTextNode('1'));

        $this->visitObjectStart('ExampleObject');
        $this->visitPropertyStart('foo');
        $this->visitNumber(1);
        $this->visitPropertyEnd('foo');
        $this->visitObjectEnd('ExampleObject');

        $this->getResult()->shouldHaveSameXmlAs($dom);
    }

    function it_should_handle_a_boolean()
    {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));
        $root->appendChild($foo = $dom->createElement('foo'));
        $foo->appendChild($dom->createTextNode('true'));

        $this->visitObjectStart('ExampleObject');
        $this->visitPropertyStart('foo');
        $this->visitBoolean(true);
        $this->visitPropertyEnd('foo');
        $this->visitObjectEnd('ExampleObject');

        $this->getResult()->shouldHaveSameXmlAs($dom);
    }

    public function getMatchers()
    {
        return [
            'haveSameXmlAs' => function (DOMDocument $subject, DOMDocument $element) {
                return $subject->saveXML() === $element->saveXML();
            }
        ];
    }
}
