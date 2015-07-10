<?php

namespace Scato\Serializer\Common;

use Scato\Serializer\Core\ObjectAccessorInterface;

/**
 * Accesses the properties of a Plain Old PHP Object
 */
class SimpleAccessor implements ObjectAccessorInterface
{
    /**
     * {@inheritdoc}
     *
     * @param object $object
     * @return array
     */
    public function getNames($object)
    {
        return array_keys(get_object_vars($object));
    }

    /**
     * {@inheritdoc}
     *
     * @param object $object
     * @param string $name
     * @return mixed
     */
    public function getValue($object, $name)
    {
        return $object->{$name};
    }
}
