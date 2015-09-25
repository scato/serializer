<?php

namespace Scato\Serializer\Navigation;

/**
 * Transforms some piece of input before passing it back
 */
interface SerializationConverterInterface
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function convert($value);
}
