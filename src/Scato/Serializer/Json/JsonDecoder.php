<?php

namespace Scato\Serializer\Json;

use Scato\Serializer\Core\DecoderInterface;

class JsonDecoder implements DecoderInterface
{

    public function decode($value)
    {
        return json_decode($value);
    }
}
