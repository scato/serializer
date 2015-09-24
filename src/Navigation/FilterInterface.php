<?php

namespace Scato\Serializer\Navigation;

/**
 * Transforms some piece of input before passing it back
 */
interface FilterInterface
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function filter($value);
}
