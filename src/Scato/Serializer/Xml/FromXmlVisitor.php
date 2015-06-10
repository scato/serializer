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

        if (in_array($type, array('int', 'integer'))) {
            $this->results->push(intval($value));
        } else if (in_array($type, array('float'))) {
            $this->results->push(floatval($value));
        } else if (in_array($type, array('bool', 'boolean'))) {
            $this->results->push($value === 'true');
        } else {
            $this->results->push($value);
        }
    }

    protected function createObject()
    {
        $type = $this->types->top();

        if (!preg_match('/\\[\\]$/', $type)) {
            $this->deleteArrayWrappers();

            parent::createObject();
        } else {
            $this->deleteEntryWrapper();
        }
    }

    protected function pushPropertyType($name)
    {
        $type = $this->types->top();
        $inArray = $type === null || $type === 'array' || preg_match('/\\[\\]$/', $type);

        if (!$inArray) {
            parent::pushPropertyType($name);
        } else {
            parent::pushElementType($name);
        }
    }

    private function createArrayType()
    {
        $type = $this->types->pop();

        if ($type !== null) {
            $type = $type . '[]';
        }

        $this->types->push($type);
    }

    private function deleteArrayType()
    {
        $type = $this->types->pop();

        if ($type !== null) {
            $type = preg_replace('/\\[\\]$/', '', $type);
        }

        $this->types->push($type);
    }

    private function deleteArrayWrappers()
    {
        $array = $this->results->pop();
        foreach ($array as $key => $value) {
            $array[$key] = $value[0];
        }
        $this->results->push($array);
    }

    private function deleteEntryWrapper()
    {
        $result = $this->results->pop();
        $this->results->push($result['entry']);
    }
}
