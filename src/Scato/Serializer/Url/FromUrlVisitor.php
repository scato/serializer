<?php

namespace Scato\Serializer\Url;

use Scato\Serializer\Common\MapToObjectVisitor;

class FromUrlVisitor extends MapToObjectVisitor
{
    public function visitArrayStart()
    {
        if ($this->inArray(1)) {
            parent::visitArrayStart();
        } else {
            parent::visitObjectStart('array');
        }
    }

    public function visitArrayEnd()
    {
        if ($this->inArray(1)) {
            parent::visitArrayEnd();
        } else {
            parent::visitObjectEnd('array');
        }
    }

    public function visitElementStart($key)
    {
        if ($this->inArray(1)) {
            parent::visitElementStart($key);
        } else {
            parent::visitPropertyStart($key);
        }
    }

    public function visitElementEnd($key)
    {
        if ($this->inArray(2)) {
            parent::visitElementEnd($key);
        } else {
            parent::visitPropertyEnd($key);
        }
    }

    public function visitString($value)
    {
        $type = $this->peekType(1);

        if (in_array($type, array('int', 'integer'))) {
            parent::visitNumber(intval($value));
        } else if (in_array($type, array('float'))) {
            parent::visitNumber(floatval($value));
        } else if (in_array($type, array('bool', 'boolean'))) {
            parent::visitBoolean($value === '1');
        } else {
            parent::visitString($value);
        }
    }

    private function inArray($count)
    {
        $type = $this->peekType($count);

        return $type === null || $type === 'array' || preg_match('/\\[\\]$/', $type);
    }
}
