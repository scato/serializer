<?php

namespace Scato\Serializer\Url;

use InvalidArgumentException;
use Scato\Serializer\Core\EncoderInterface;

/**
 * Encodes URL encoded strings
 */
class UrlEncoder implements EncoderInterface
{
    /**
     * Turn array into URL encoded string
     *
     * @param mixed $value
     * @return string
     * @throws InvalidArgumentException
     */
    public function encode($value)
    {
        if (!is_array($value)) {
            throw new InvalidArgumentException("UrlEncoder only accepts values of type array");
        }

        return http_build_query($value);
    }
}
