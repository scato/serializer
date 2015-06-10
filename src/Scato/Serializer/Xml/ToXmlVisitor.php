<?php

namespace Scato\Serializer\Xml;

use DOMDocument;
use DOMElement;
use Scato\Serializer\Common\ObjectToArrayVisitor;

class ToXmlVisitor extends ObjectToArrayVisitor
{
    /**
     * @var DOMDocument|null
     */
    private $document = null;

    public function getResult()
    {
        $result = parent::getResult();

        $document = $this->getDocument();
        $document->appendChild($result);

        $this->flushDocument();

        return $document;
    }

    public function visitObjectEnd($class)
    {
        parent::visitArrayEnd();

        $array = $this->popResult();
        $root = $this->getDocument()->createElement('root');

        foreach ($array as $name => $property) {
            $this->setValue($root, $name, $property);
        }

        $this->pushResult($root);
    }

    public function visitBoolean($value)
    {
        $this->pushResult($value ? 'true' : 'false');
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

    private function getDocument()
    {
        if ($this->document === null) {
            $this->document = new DOMDocument();
        }

        return $this->document;
    }

    private function flushDocument()
    {
        $this->document = null;
    }
}
