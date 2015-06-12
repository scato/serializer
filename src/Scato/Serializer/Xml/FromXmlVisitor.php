<?php

namespace Scato\Serializer\Xml;

use Scato\Serializer\Common\DeserializeVisitor;

class FromXmlVisitor extends DeserializeVisitor
{
    public function visitPropertyStart($name)
    {
        parent::visitPropertyStart($name);

        $this->createArrayType();
    }

    public function visitPropertyEnd($name)
    {
        $this->deleteArrayType();

        parent::visitPropertyEnd($name);
    }

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

    protected function pushPropertyType($name)
    {
        $type = $this->types->top();

        if ($type->isClass()) {
            parent::pushPropertyType($name);
        } else {
            parent::pushElementType($name);
        }
    }

    private function createArrayType()
    {
        $type = $this->types->pop();

        if ($type !== null) {
            $type = $type->getArrayType();
        }

        $this->types->push($type);
    }

    private function deleteArrayType()
    {
        $type = $this->types->pop();

        if ($type !== null) {
            $type = $type->getElementType();
        }

        $this->types->push($type);
    }

    /**
     * Because we get properties as arrays, we need to take the first of each array to end up with the values
     * themselves.
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
     * Arrays look like objects with one property named entry, which can actually have a length other than 1.
     */
    private function createIndexedArray()
    {
        $result = $this->results->pop();

        $this->results->push($result['entry']);
    }
}
