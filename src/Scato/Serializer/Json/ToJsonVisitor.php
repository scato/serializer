<?php

namespace Scato\Serializer\Json;

use Scato\Serializer\Common\SerializeVisitor;

/**
 * Turns an object graph into a data tree
 *
 * All objects are transformed into objects of stdClass
 * All other values keep their original type
 *
 * A result stack is used to store temporary results while traversing the object graph
 */
class ToJsonVisitor extends SerializeVisitor
{
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    protected function createObject()
    {
//        $result = $this->results->pop();
//
//        $this->results->push((object) $result);
    }
}
