<?php

namespace Scato\Serializer\Json;

use Scato\Serializer\Common\SerializeVisitor;

class ToJsonVisitor extends SerializeVisitor
{
    protected function createObject()
    {
        $result = $this->results->pop();

        $this->results->push((object)$result);
    }
}
