<?php

namespace Scato\Serializer\Common;

use Scato\Serializer\Core\ObjectAccessorInterface;

class SimpleAccessor implements ObjectAccessorInterface
{
    public function getNames($object)
    {
        return array_keys(get_object_vars($object));
    }

    public function getValue($object, $name)
    {
        return $object->{$name};
    }
}