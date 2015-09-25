<?php

namespace Scato\Serializer\Navigation;

use Scato\Serializer\Core\Type;

/**
 * Creates objects
 */
interface ObjectFactoryInterface
{
    /**
     * Create an object of specified type based on an arbitrary value
     *
     * @param Type  $type
     * @param mixed $value
     * @return mixed
     */
    public function createObject(Type $type, $value);
}
