<?php

namespace Scato\Serializer\Url;

use Scato\Serializer\Common\ObjectToArrayVisitor;

class ToUrlVisitor extends ObjectToArrayVisitor
{
    public function __construct()
    {
    }

    public function visitNull()
    {
        $this->pushResult('');
    }

    public function visitNumber($value)
    {
        $this->pushResult((string) $value);
    }

    public function visitBoolean($value)
    {
        $this->pushResult($value ? '1' : '0');
    }
}
