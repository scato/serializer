<?php

namespace Scato\Serializer\Navigation;

use Scato\Serializer\Core\Type;

/**
 * Either overrides or delegates object creation
 */
interface DeserializationFilterInterface
{
    /**
     * @param Type                   $type
     * @param mixed                  $value
     * @param ObjectFactoryInterface $next
     * @return mixed
     */
    public function filter(Type $type, $value, ObjectFactoryInterface $next);
}
