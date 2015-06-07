<?php

namespace Scato\Serializer\Url;

use Scato\Serializer\Common\MapToObjectVisitor;

class FromUrlVisitor extends MapToObjectVisitor
{
    public function visitArrayEnd()
    {
        $type = $this->peekType(1);
        $inArray = $type === null || $type === 'array' || preg_match('/\\[\\]$/', $type);

        if ($inArray) {
            parent::visitArrayEnd();
        } else {
            parent::visitObjectEnd('array');
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
}
