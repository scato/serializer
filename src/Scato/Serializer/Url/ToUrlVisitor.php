<?php

namespace Scato\Serializer\Url;

use Scato\Serializer\Common\AbstractVisitor;

class ToUrlVisitor extends AbstractVisitor
{
    public function __construct()
    {
    }

    public function visitObjectStart($class)
    {
        $this->visitArrayStart();
    }

    public function visitObjectEnd($class)
    {
        $this->visitArrayEnd();
    }

    public function visitPropertyStart($name)
    {
        $this->visitElementStart($name);
    }

    public function visitPropertyEnd($name)
    {
        $this->visitElementEnd($name);
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
