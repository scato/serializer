<?php

namespace Scato\Serializer\Json;

use Scato\Serializer\Core\EncoderInterface;

class JsonEncoder implements EncoderInterface
{
    public function encode($value)
    {
        return json_encode($value);
    }
}
