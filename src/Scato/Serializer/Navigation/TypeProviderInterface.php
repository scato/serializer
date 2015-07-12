<?php

namespace Scato\Serializer\Navigation;

use Scato\Serializer\Core\Type;

/**
 * Provides property types
 */
interface TypeProviderInterface
{
    /**
     * Fetch the type of one property
     *
     * @param Type   $class
     * @param string $name
     * @return Type
     */
    public function getType(Type $class, $name);
}
