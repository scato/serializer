<?php

namespace Scato\Serializer\Url;

use Scato\Serializer\Common\DeserializeVisitor;

class FromUrlVisitor extends DeserializeVisitor
{
    public function visitArrayEnd()
    {
        parent::visitArrayEnd();

        $this->createObject();
    }

    public function visitValue($value)
    {
        $type = $this->types->top();

        if (in_array($type, array('int', 'integer'))) {
            $this->results->push(intval($value));
        } else if (in_array($type, array('float'))) {
            $this->results->push(floatval($value));
        } else if (in_array($type, array('bool', 'boolean'))) {
            $this->results->push($value === '1');
        } else {
            $this->results->push($value);
        }
    }

    protected function createObject()
    {
        if ($this->inObject()) {
            parent::createObject();
        }
    }

    protected function pushElementType($key)
    {
        if ($this->inObject()) {
            parent::pushPropertyType($key);
        } else {
            parent::pushElementType($key);
        }
    }

    private function inObject()
    {
        $type = $this->types->top();

        if ($type === null || $type === 'mixed') {
            return false;
        }

        if (in_array($type, array('array', 'int', 'integer', 'float', 'bool', 'boolean', 'string'))) {
            return false;
        }

        if (preg_match('/\\[\\]$/', $type)) {
            return false;
        }

        return true;
    }
}
