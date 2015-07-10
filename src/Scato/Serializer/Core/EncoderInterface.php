<?php
namespace Scato\Serializer\Core;

/**
 * Encodes strings
 */
interface EncoderInterface
{
    /**
     * Turn data tree into string
     *
     * @param mixed $value
     * @return string
     */
    public function encode($value);
}
