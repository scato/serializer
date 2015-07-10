<?php

namespace Scato\Serializer\Json;

use Scato\Serializer\Core\DecoderInterface;

/**
 * Decodes JSON strings
 */
class JsonDecoder implements DecoderInterface
{
    /**
     * Turn string into data tree
     *
     * @param string $value
     * @return mixed
     */
    public function decode($value)
    {
        return json_decode($value);
    }
}
