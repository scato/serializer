<?php

namespace Scato\Serializer\Xml;

use DOMDocument;
use DOMElement;
use InvalidArgumentException;
use Scato\Serializer\Core\ObjectAccessorInterface;

class DOMElementAccessor implements ObjectAccessorInterface
{
    public function getNames($object)
    {
        if ($object instanceof DOMDocument) {
            $object = $object->documentElement;
        }

        if (!($object instanceof DOMElement)) {
            throw new InvalidArgumentException("SimpleXmlElementAccessor only accepts values of type DOMElement");
        }

        $nodeNames = array();

        foreach ($object->childNodes as $childNode) {
            if ($childNode->nodeType === XML_ELEMENT_NODE) {
                $nodeNames[] = $childNode->nodeName;
            }
        }

        return array_unique($nodeNames);
    }

    public function getValue($object, $name)
    {
        if ($object instanceof DOMDocument) {
            $object = $object->documentElement;
        }

        if (!($object instanceof DOMElement)) {
            throw new InvalidArgumentException("SimpleXmlElementAccessor only accepts values of type DOMElement");
        }

        $values = array();

        foreach ($object->childNodes as $childNode) {
            if ($childNode->nodeName === $name) {
                $hasOneChildNode = $childNode->childNodes->length === 1;
                $isValue = $hasOneChildNode && $childNode->childNodes->item(0)->nodeType === XML_TEXT_NODE;

                $values[] = $isValue ? $childNode->nodeValue : $childNode;
            }
        }

        return $values;
    }
}
