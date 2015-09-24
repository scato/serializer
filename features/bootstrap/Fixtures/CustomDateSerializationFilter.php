<?php

namespace Fixtures;

use DateTime;
use Scato\Serializer\Navigation\FilterInterface;

class CustomDateSerializationFilter implements FilterInterface
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function filter($value)
    {
        if ($value instanceof DateTime) {
            return $value->format('c');
        }

        return $value;
    }
}
