<?php

namespace Scato\Serializer\Data;

use InvalidArgumentException;
use Scato\Serializer\Common\ObjectFactoryInterface;
use Scato\Serializer\Core\Type;

class SafeObjectFactory implements ObjectFactoryInterface
{
    public function createObject(Type $type, $properties)
    {
        if (!$type->isClass()) {
            throw new InvalidArgumentException("Cannot create object for non-class type: '{$type->toString()}'");
        }

        $class = $type->toString();

        $object = new $class();
        $names = array_keys(get_object_vars($object));

        foreach ($properties as $name => $property) {
            if (in_array($name, $names)) {
                $object->{$name} = $property;
            }
        }

        return $object;
    }
}
