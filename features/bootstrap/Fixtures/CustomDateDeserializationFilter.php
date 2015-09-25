<?php

namespace Fixtures;

use DateTime;
use Scato\Serializer\Core\Type;
use Scato\Serializer\Navigation\DeserializationFilterInterface;
use Scato\Serializer\Navigation\ObjectFactoryInterface;

class CustomDateDeserializationFilter implements DeserializationFilterInterface
{
    public function filter(Type $type, $value, ObjectFactoryInterface $next)
    {
        if ($type->toString() === 'DateTime') {
            return DateTime::createFromFormat('c', $value);
        }

        return $next->createObject($type, $value);
    }
}
