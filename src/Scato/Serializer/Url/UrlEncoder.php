<?php

namespace Scato\Serializer\Url;

use Scato\Serializer\Core\EncoderInterface;

class UrlEncoder implements EncoderInterface
{
    /**
     * @param array $value
     * @return string
     */
    public function encode($value)
    {
        if (!is_array($value)) {
            throw new \InvalidArgumentException("UrlEncoder only accepts values of type array");
        }

        return http_build_query($value);
    }
}
