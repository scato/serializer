<?php

namespace Scato\Serializer\Xml;

use Scato\Serializer\Common\MapToObjectVisitor;

class FromXmlVisitor extends MapToObjectVisitor
{
    public function visitObjectStart($class)
    {
        parent::visitArrayStart($class);
    }

    public function visitObjectEnd($class)
    {
        $type = $this->peekType(1);

        if (preg_match('/\\[\\]$/', $type)) {
            parent::visitArrayEnd();
        } else {
            parent::visitObjectEnd($class);
        }
    }

    public function visitPropertyEnd($name)
    {
        $type = $this->peekType(2);

        if (preg_match('/\\[\\]$/', $type)) {
            parent::visitPropertyEnd($name);

            $result = $this->popResult();
            $this->pushResult($result['entry']);
        } else {
            $result = $this->popResult();
            $this->pushResult($result[0]);

            parent::visitPropertyEnd($name);
        }
    }

    public function visitArrayStart()
    {
        $type = $this->popType();

        if ($type !== null) {
            $type = $type . '[]';
        }

        $this->pushType($type);

        parent::visitArrayStart();
    }

    public function visitArrayEnd()
    {
        parent::visitArrayEnd();

        $type = $this->popType();

        if ($type !== null) {
            $type = preg_replace('/\\[\\]$/', '', $type);
        }

        $this->pushType($type);
    }

    public function visitString($value)
    {
        $type = $this->peekType(1);

        if (in_array($type, array('int', 'integer'))) {
            parent::visitNumber(intval($value));
        } else if (in_array($type, array('float'))) {
            parent::visitNumber(floatval($value));
        } else if (in_array($type, array('bool', 'boolean'))) {
            parent::visitBoolean($value === 'true');
        } else {
            parent::visitString($value);
        }
    }
}
