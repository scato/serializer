<?php

namespace Scato\Serializer\Core;

/**
 * Decodes strings
 */
interface DecoderInterface
{
    /**
     * Turn string into data tree
     *
     * @param string $value
     * @return mixed
     */
    public function decode($value);
}
