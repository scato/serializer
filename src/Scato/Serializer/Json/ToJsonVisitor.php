<?php

namespace Scato\Serializer\Json;

use Scato\Serializer\Common\ObjectToArrayVisitor;

class ToJsonVisitor extends ObjectToArrayVisitor
{
    public function visitObjectEnd($class)
    {
        parent::visitArrayEnd();

        $result = $this->popResult();

        $this->pushResult((object) $result);
    }

}
