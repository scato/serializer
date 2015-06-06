<?php

namespace Scato\Serializer\Common;

use Scato\Serializer\Core\ObjectAccessorInterface;

class PublicAccessor implements ObjectAccessorInterface
{
    public function getNames($object)
    {
        return array_keys(get_object_vars($object));
    }

    public function getValue($object, $name)
    {
        return $object->{$name};
    }

    public function setValue($object, $name, $value)
    {
        $object->{$name} = $value;
    }
}
