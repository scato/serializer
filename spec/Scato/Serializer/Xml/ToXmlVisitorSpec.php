<?php

namespace spec\Scato\Serializer\Xml;

use DOMDocument;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ToXmlVisitorSpec extends ObjectBehavior
{
    function it_should_be_an_object_to_array_visitor()
    {
        $this->shouldHaveType('Scato\Serializer\Common\SerializeVisitor');
    }

    function it_should_handle_an_empty_object() {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));

        $this->visitArrayStart();
        $this->visitArrayEnd();

        $this->getResult()->shouldHaveSameXmlAs($dom);
    }

    function it_should_handle_an_object_with_a_string() {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));
        $root->appendChild($foo = $dom->createElement('foo'));
        $foo->appendChild($dom->createTextNode('bar'));

        $this->visitArrayStart();
        $this->visitElementStart('foo');
        $this->visitValue('bar');
        $this->visitElementEnd('foo');
        $this->visitArrayEnd();

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

        $this->visitArrayStart();
        $this->visitElementStart('foo');
        $this->visitArrayStart();
        $this->visitElementStart(0);
        $this->visitValue('bar');
        $this->visitElementEnd(0);
        $this->visitElementStart(1);
        $this->visitValue('baz');
        $this->visitElementEnd(1);
        $this->visitArrayEnd();
        $this->visitElementEnd('foo');
        $this->visitArrayEnd();

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

        $this->visitArrayStart();
        $this->visitElementStart('foo');
        $this->visitArrayStart();
        $this->visitElementStart('bar');
        $this->visitValue('baz');
        $this->visitElementEnd('bar');
        $this->visitElementStart('foz');
        $this->visitValue('baz');
        $this->visitElementEnd('foz');
        $this->visitArrayEnd();
        $this->visitElementEnd('foo');
        $this->visitArrayEnd();

        $this->getResult()->shouldHaveSameXmlAs($dom);
    }

    function it_should_handle_null()
    {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));
        $root->appendChild($foo = $dom->createElement('foo'));
        $foo->appendChild($dom->createTextNode(''));

        $this->visitArrayStart();
        $this->visitElementStart('foo');
        $this->visitValue(null);
        $this->visitElementEnd('foo');
        $this->visitArrayEnd();

        $this->getResult()->shouldHaveSameXmlAs($dom);
    }

    function it_should_handle_a_number()
    {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));
        $root->appendChild($foo = $dom->createElement('foo'));
        $foo->appendChild($dom->createTextNode('1'));

        $this->visitArrayStart();
        $this->visitElementStart('foo');
        $this->visitValue(1);
        $this->visitElementEnd('foo');
        $this->visitArrayEnd();

        $this->getResult()->shouldHaveSameXmlAs($dom);
    }

    function it_should_handle_a_boolean()
    {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));
        $root->appendChild($foo = $dom->createElement('foo'));
        $foo->appendChild($dom->createTextNode('true'));

        $this->visitArrayStart();
        $this->visitElementStart('foo');
        $this->visitValue(true);
        $this->visitElementEnd('foo');
        $this->visitArrayEnd();

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
