<?php

namespace Scato\Serializer\Xml;

use DOMDocument;
use DOMElement;
use Scato\Serializer\Common\SerializeVisitor;

class ToXmlVisitor extends SerializeVisitor
{
    /**
     * @var DOMDocument|null
     */
    private $document = null;

    public function getResult()
    {
        $this->finishDocument();

        return parent::getResult();
    }

    public function visitValue($value)
    {
        if (is_bool($value)) {
            $this->results->push($value ? 'true' : 'false');
        } else {
            $this->results->push((string) $value);
        }
    }

    private function getDocument()
    {
        if ($this->document === null) {
            $this->document = new DOMDocument();
        }

        return $this->document;
    }

    private function finishDocument()
    {
        $result = $this->results->pop();

        $document = $this->getDocument();
        $document->appendChild($result);

        $this->document = null;

        $this->results->push($document);
    }

    protected function createObject()
    {
        $array = $this->results->pop();
        $root = $this->getDocument()->createElement('root');

        foreach ($array as $name => $property) {
            $this->setValue($root, $name, $property);
        }

        $this->results->push($root);
    }

    private function setValue(DOMElement $root, $name, $property)
    {
        $dom = $this->getDocument();

        $childNode = $dom->createElement($name);

        if ($property instanceof DOMElement) {
            while ($property->childNodes->length > 0) {
                $childNode->appendChild($property->childNodes->item(0));
            }
        } elseif (is_array($property)) {
            foreach ($property as $propertyKey => $propertyElement) {
                $this->setValue($childNode, 'entry', $propertyElement);
            }
        } else {
            $childNode->appendChild($dom->createTextNode($property));
        }

        $root->appendChild($childNode);
    }
}
