<?php

namespace Fixtures;

use DateTime;
use Scato\Serializer\Navigation\SerializationConverterInterface;

class CustomDateSerializationConverter implements SerializationConverterInterface
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function convert($value)
    {
        if ($value instanceof DateTime) {
            return $value->format('c');
        }

        return $value;
    }
}
