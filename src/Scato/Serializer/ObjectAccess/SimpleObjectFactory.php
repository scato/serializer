<?php

namespace Scato\Serializer\ObjectAccess;

use InvalidArgumentException;
use Scato\Serializer\Core\Type;
use Scato\Serializer\Navigation\ObjectFactoryInterface;

/**
 * Creates Plain Old PHP Objects
 */
class SimpleObjectFactory implements ObjectFactoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @param Type  $type
     * @param array $properties
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function createObject(Type $type, array $properties)
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
