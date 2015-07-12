<?php

namespace Scato\Serializer\Xml;

use DOMDocument;
use DOMElement;
use DOMText;
use Scato\Serializer\Common\SerializeVisitor;

/**
 * Turns an object graph into a DOMDocument
 *
 * All values are turned into elements
 * The root element is named 'root'
 * Property elements are named after the corresponding property name
 * Arrays get an 'entry' tag for each element in the array
 * Booleans are converted to 'true' or 'false'
 * The other scalar values are converted to strings
 *
 * The final result on the stack is a DOMElement, but getResult replaces it with its DOMDocument
 */
class ToXmlVisitor extends SerializeVisitor
{
    /**
     * @var DOMDocument|null
     */
    private $document = null;

    /**
     * @return mixed
     */
    public function getResult()
    {
        $this->finishDocument();

        return parent::getResult();
    }

    /**
     * @return void
     */
    public function visitObjectStart()
    {
        $root = $this->getDocument()->createElement('root');

        $this->results->push($root);
    }

    /**
     * @param string $name
     * @return void
     */
    public function visitPropertyStart($name)
    {
        $property = $this->getDocument()->createElement($name);

        $this->results->push($property);
    }

    /**
     * @return void
     */
    public function visitArrayStart()
    {
        $root = $this->getDocument()->createElement('root');

        $this->results->push($root);
    }

    /**
     * @param integer|string $key
     * @return void
     */
    public function visitElementStart($key)
    {
        if (is_numeric($key)) {
            $property = $this->getDocument()->createElement('entry');
        } else {
            $property = $this->getDocument()->createElement($key);
        }

        $this->results->push($property);
    }

    /**
     * @param mixed $value
     * @return void
     */
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

    /**
     * @return DOMDocument
     */
    private function getDocument()
    {
        if ($this->document === null) {
            $this->document = new DOMDocument();
        }

        return $this->document;
    }

    /**
     * @return void
     */
    private function finishDocument()
    {
        $result = $this->results->pop();

        $document = $this->getDocument();
        $document->appendChild($result);

        $this->document = null;

        $this->results->push($document);
    }

    /**
     * @param integer|string $key
     * @return void
     */
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
