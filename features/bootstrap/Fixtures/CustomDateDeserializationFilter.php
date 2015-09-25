<?php

namespace Fixtures;

use DateTime;
use Scato\Serializer\Core\Type;
use Scato\Serializer\Navigation\ObjectFactoryInterface;

class CustomDateDeserializationFilter
{
    public function filter(Type $type, $value, ObjectFactoryInterface $next)
    {
        if ($type->toString() === 'DateTime') {
            return new DateTime($value);
        }

        return $next->createObject($type, $value);
    }
}
