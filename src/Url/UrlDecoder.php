<?php

namespace Scato\Serializer\Url;

use Scato\Serializer\Core\DecoderInterface;

/**
 * Decodes URL encoded strings
 */
class UrlDecoder implements DecoderInterface
{
    /**
     * Turns URL encoded string into array
     *
     * @param string $value
     * @return mixed
     */
    public function decode($value)
    {
        parse_str($value, $result);

        return $result;
    }
}
