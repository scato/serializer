<?php

namespace Scato\Serializer\Xml;

use DOMDocument;
use DOMElement;
use InvalidArgumentException;
use Scato\Serializer\Navigation\ObjectAccessorInterface;

/**
 * Accesses the childNodes of a DOMElement as properties
 */
class DOMElementAccessor implements ObjectAccessorInterface
{
    /**
     * {@inheritdoc}
     *
     * @param object $object
     * @return array
     * @throws InvalidArgumentException
     */
    public function getNames($object)
    {
        if ($object instanceof DOMDocument) {
            $object = $object->documentElement;
        }

        if (!($object instanceof DOMElement)) {
            throw new InvalidArgumentException("DOMElementAccessor only accepts values of type DOMElement");
        }

        $nodeNames = array();

        foreach ($object->childNodes as $childNode) {
            if ($childNode->nodeType === XML_ELEMENT_NODE) {
                $nodeNames[] = $childNode->nodeName;
            }
        }

        return array_unique($nodeNames);
    }

    /**
     * {@inheritdoc}
     *
     * @param object $object
     * @param string $name
     * @return array
     * @throws InvalidArgumentException
     */
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
