<?php

namespace Scato\Serializer\Xml;

use DOMDocument;
use DOMElement;
use DOMText;
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

    public function visitObjectStart()
    {
        $root = $this->getDocument()->createElement('root');

        $this->results->push($root);
    }

    public function visitPropertyStart($name)
    {
        $property = $this->getDocument()->createElement($name);

        $this->results->push($property);
    }

    public function visitArrayStart()
    {
        $root = $this->getDocument()->createElement('root');

        $this->results->push($root);
    }

    public function visitElementStart($key)
    {
        $property = $this->getDocument()->createElement('entry');

        $this->results->push($property);
    }

    public function visitValue($value)
    {
        if (is_bool($value)) {
            $content = $value ? 'true' : 'false';
        } else {
            $content = (string) $value;
        }

        $text = $this->getDocument()->createTextNode($content);

        $this->results->push($text);
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

    protected function createElement($key)
    {
        $value = $this->results->pop();
        $child = $this->results->pop();
        $parent = $this->results->pop();

        if ($value instanceof DOMElement) {
            while ($value->childNodes->length > 0) {
                $child->appendChild($value->childNodes->item(0));
            }
        } else {
            $child->appendChild($value);
        }

        $parent->appendChild($child);

        $this->results->push($parent);
    }
}
