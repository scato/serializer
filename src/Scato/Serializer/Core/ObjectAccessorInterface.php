<?php
namespace Scato\Serializer\Core;

/**
 * Accesses the properties of an object
 */
interface ObjectAccessorInterface
{
    /**
     * Fetch a list of property names
     *
     * @param object $object
     * @return string[]
     */
    public function getNames($object);

    /**
     * Fetch the value of one property
     *
     * @param object $object
     * @param string $name
     * @return mixed
     */
    public function getValue($object, $name);
}
