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
            // unfortunately, createFromFormat() doesn't accept 'c' as a format
            return DateTime::createFromFormat('Y-m-d\\TH:i:sP', $value);
        }

        return $next->createObject($type, $value);
    }
}
