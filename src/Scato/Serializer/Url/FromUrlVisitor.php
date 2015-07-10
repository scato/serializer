<?php

namespace Scato\Serializer\Url;

use Scato\Serializer\Common\DeserializeVisitor;

/**
 * Turns an array into an object graph
 *
 * Objects do not appear in URL encoded data
 * All arrays are transformed into an object of the appropriate type using an ObjectFactory
 * Strings are transformed into the appropriate scalar type
 */
class FromUrlVisitor extends DeserializeVisitor
{
    /**
     * @return void
     */
    public function visitArrayEnd()
    {
        parent::visitArrayEnd();

        $this->createObject();
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
            $this->results->push($value === '1');
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
            parent::createObject();
        }
    }

    /**
     * {$inheritdoc}
     *
     * @param integer|string $key
     * @return void
     */
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
