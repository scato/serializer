<?php

namespace Fixtures;

use DateTime;
use Scato\Serializer\Core\Type;
use Scato\Serializer\Navigation\DeserializationFilterInterface;
use Scato\Serializer\Navigation\ObjectFactoryInterface;

class CustomDateDeserializationFilter implements DeserializationFilterInterface
{
    /**
     * @param Type                   $type
     * @param mixed                  $value
     * @param ObjectFactoryInterface $next
     * @return mixed
     */
    public function filter(Type $type, $value, ObjectFactoryInterface $next)
    {
        if ($type->toString() === 'DateTime') {
            return DateTime::createFromFormat(DateTime::W3C, $value);
        }

        return $next->createObject($type, $value);
    }
}
