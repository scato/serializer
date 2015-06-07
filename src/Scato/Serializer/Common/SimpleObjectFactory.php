<?php

namespace Scato\Serializer\Common;

class SimpleObjectFactory implements ObjectFactoryInterface
{
    public function createObject($class, $properties)
    {
        $object = new $class();

        foreach ($properties as $name => $property) {
            $object->{$name} = $property;
        }

        return $object;
    }
}
