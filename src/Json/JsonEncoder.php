<?php

namespace Scato\Serializer\Json;

use Scato\Serializer\Core\EncoderInterface;

/**
 * Encodes JSON strings
 */
class JsonEncoder implements EncoderInterface
{
    /**
     * Turn data tree into string
     *
     * @param mixed $value
     * @return string
     */
    public function encode($value)
    {
        return json_encode($value);
    }
}
