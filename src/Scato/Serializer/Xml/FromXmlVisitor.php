<?php

namespace Scato\Serializer\Xml;

use Scato\Serializer\Common\DeserializeVisitor;

/**
 * Turns a DOMDocument into an object graph
 *
 * The DOMDocument is accessed through the DOMElementAccessor
 * The DOMElementAccessor wraps each property in an array
 * Tags corresponding to properties should occur only once
 * Tags corresponding to elements of an array (called 'entry') can occur any number of times
 *
 * Because properties are wrapped in arrays, the associated type should be corrected as well
 * After visiting a tag that corresponds to an object, an associative array should be produced
 * After visiting a tag that corresponds to an array, an indexed array should be produced
 */
class FromXmlVisitor extends DeserializeVisitor
{
    /**
     * @param string $name
     * @return void
     */
    public function visitPropertyStart($name)
    {
        parent::visitPropertyStart($name);

        $this->createArrayType();
    }

    /**
     * @param string $name
     * @return void
     */
    public function visitPropertyEnd($name)
    {
        $this->deleteArrayType();

        parent::visitPropertyEnd($name);
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function visitValue($value)
    {
        $type = $this->types->top();

        if ($type->isInteger()) {
            $this->results->push(intval($value));
        } elseif ($type->isFloat()) {
            $this->results->push(floatval($value));
        } elseif ($type->isBoolean()) {
            $this->results->push($value === 'true');
        } else {
            $this->results->push($value);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    protected function createObject()
    {
        $type = $this->types->top();

        if ($type->isClass()) {
            $this->createAssociativeArray();

            parent::createObject();
        } else {
            $this->createIndexedArray();
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param string $name
     * @return void
     */
    protected function pushPropertyType($name)
    {
        $type = $this->types->top();

        if ($type->isClass()) {
            parent::pushPropertyType($name);
        } else {
            parent::pushElementType($name);
        }
    }

    /**
     * Replace the top of the type stack with the type for an array containing values of that type
     *
     * For example: replace string with string[]
     *
     * @return void
     */
    private function createArrayType()
    {
        $type = $this->types->pop();

        if ($type !== null) {
            $type = $type->getArrayType();
        }

        $this->types->push($type);
    }

    /**
     * Replace the top of the type stack with the type for the elements of that type
     *
     * For example: replace string[] with string
     *
     * @return void
     */
    private function deleteArrayType()
    {
        $type = $this->types->pop();

        if ($type !== null) {
            $type = $type->getElementType();
        }

        $this->types->push($type);
    }

    /**
     * Replace the top of the result stack with the appropriate associative array
     *
     * Because we get properties as arrays, we need to take the first of each array to end up with the values
     * themselves
     *
     * For example: replace ['foo' => ['bar']] with ['foo' => 'bar']
     *
     * @return void
     */
    private function createAssociativeArray()
    {
        $array = $this->results->pop();

        foreach ($array as $key => $value) {
            $array[$key] = $value[0];
        }

        $this->results->push($array);
    }

    /**
     * Replace the top of the result stack with the appropriate indexed array
     *
     * Arrays look like objects with one property named entry, which can actually have a length other than 1
     *
     * For example: replace ['entry' => ['foo', 'bar']] with ['foo', 'bar']
     *
     * @return void
     */
    private function createIndexedArray()
    {
        $result = $this->results->pop();

        $this->results->push($result['entry']);
    }
}
