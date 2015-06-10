<?php

namespace Scato\Serializer\Url;

use Scato\Serializer\Common\SerializeVisitor;

class ToUrlVisitor extends SerializeVisitor
{
    public function visitValue($value)
    {
        if (is_bool($value)) {
            $this->results->push($value ? '1' : '0');
        } else {
            $this->results->push((string) $value);
        }
    }
}
