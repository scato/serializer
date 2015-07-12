<?php

namespace spec\Scato\Serializer\Xml;

use DOMDocument;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use stdClass;

class DOMElementAccessorSpec extends ObjectBehavior
{
    function it_should_be_an_accessor()
    {
        $this->shouldHaveType('Scato\Serializer\Navigation\ObjectAccessorInterface');
    }

    function it_should_only_accept_dom_elements()
    {
        $object = new stdClass();

        $this->shouldThrow(
            new InvalidArgumentException('SimpleXmlElementAccessor only accepts values of type DOMElement')
        )->duringGetNames($object);

        $this->shouldThrow(
            new InvalidArgumentException('SimpleXmlElementAccessor only accepts values of type DOMElement')
        )->duringGetValue($object, 'foo');
    }

    function it_should_handle_empty_elements()
    {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));

        $this->getNames($root)->shouldBe(array());
    }

    function it_should_find_names_for_children()
    {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));
        $root->appendChild($foo = $dom->createElement('foo'));
        $foo->appendChild($dom->createTextNode('bar'));

        $this->getNames($root)->shouldBe(array('foo'));
    }

    function it_should_read_value_children_as_strings()
    {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));
        $root->appendChild($foo = $dom->createElement('foo'));
        $foo->appendChild($dom->createTextNode('bar'));

        $this->getValue($root, 'foo')[0]->shouldBe('bar');
    }

    function it_should_read_record_children_as_elements()
    {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));
        $root->appendChild($foo = $dom->createElement('foo'));
        $foo->appendChild($bar = $dom->createElement('bar'));
        $bar->appendChild($dom->createTextNode('baz'));

        $this->getValue($root, 'foo')[0]->shouldHaveType('DOMElement');
    }

    function it_should_ignore_whitespace()
    {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));
        $root->appendChild($foo = $dom->createElement('foo'));
        $foo->appendChild($dom->createTextNode("\n"));
        $foo->appendChild($bar = $dom->createElement('bar'));
        $bar->appendChild($dom->createTextNode('baz'));
        $foo->appendChild($dom->createTextNode("\n"));

        $this->getNames($foo)->shouldBe(array('bar'));
    }

    function it_should_treat_a_document_the_same_as_the_document_element()
    {
        $dom = new DOMDocument();
        $dom->appendChild($root = $dom->createElement('root'));
        $root->appendChild($foo = $dom->createElement('foo'));
        $foo->appendChild($dom->createTextNode('bar'));

        $this->getNames($dom)->shouldBe(array('foo'));
        $this->getValue($dom, 'foo')[0]->shouldBe('bar');
    }
}
