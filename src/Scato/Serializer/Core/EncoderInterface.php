<?php
namespace Scato\Serializer\Core;

interface EncoderInterface
{
    /**
     * @param mixed $value
     * @return string
     */
    public function encode($value);
}
