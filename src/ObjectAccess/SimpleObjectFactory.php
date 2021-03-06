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
     * @param mixed $value
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function createObject(Type $type, $value)
    {
        if (!$type->isClass()) {
            throw new InvalidArgumentException("Cannot create object for non-class type: '{$type->toString()}'");
        }

        if (!is_array($value)) {
            throw new InvalidArgumentException("Cannot create object from non-array value: '{$value}'");
        }

        $class = $type->toString();

        $object = new $class();

        foreach ($value as $name => $property) {
            $object->{$name} = $property;
        }

        return $object;
    }
}
