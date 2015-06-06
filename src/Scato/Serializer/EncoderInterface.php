<?php
namespace Scato\Serializer;

interface EncoderInterface
{
    /**
     * @param mixed $value
     * @return string
     */
    public function encode($value);
}
