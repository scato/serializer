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

        if ($type->isInteger()) {
            $this->results->push(intval($value));
        } elseif ($type->isFloat()) {
            $this->results->push(floatval($value));
        } elseif ($type->isBoolean()) {
            $this->results->push($value === '1');
        } else {
            $this->results->push($value);
        }
    }

    protected function createObject()
    {
        $type = $this->types->top();

        if ($type->isClass()) {
            parent::createObject();
        }
    }

    protected function pushElementType($key)
    {
        $type = $this->types->top();

        if ($type->isClass()) {
            parent::pushPropertyType($key);
        } else {
            parent::pushElementType($key);
        }
    }
}
