<?php

namespace Scato\Serializer\Common;

use Scato\Serializer\Core\Type;

/**
 * Creates objects
 */
interface ObjectFactoryInterface
{
    /**
     * Create an object of specified type with specified properties
     *
     * @param Type  $type
     * @param array $properties
     * @return mixed
     */
    public function createObject(Type $type, array $properties);
}
