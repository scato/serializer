<?php

namespace Scato\Serializer\Common;

use InvalidArgumentException;
use Scato\Serializer\Core\Type;

class SimpleObjectFactory implements ObjectFactoryInterface
{
    public function createObject(Type $type, $properties)
    {
        if (!$type->isClass()) {
            throw new InvalidArgumentException("Cannot create object for non-class type: '{$type->toString()}'");
        }

        $class = $type->toString();

        $object = new $class();

        foreach ($properties as $name => $property) {
            $object->{$name} = $property;
        }

        return $object;
    }
}
