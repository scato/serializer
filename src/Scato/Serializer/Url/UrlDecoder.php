<?php

namespace Scato\Serializer\Url;

use Scato\Serializer\Core\DecoderInterface;

class UrlDecoder implements DecoderInterface
{
    public function decode($value)
    {
        parse_str($value, $result);

        return $result;
    }
}
