<?php

namespace Scato\Serializer\Url;

use Scato\Serializer\Navigation\SerializeVisitor;

/**
 * Turns an object graph into an array
 *
 * All objects are transformed into associative arrays
 * Arrays keep their original type
 * Booleans are converted to '1' or '0'
 * The other scalar values are converted to strings
 */
class ToUrlVisitor extends SerializeVisitor
{
    /**
     * @param mixed $value
     * @return void
     */
    public function visitValue($value)
    {
        if (is_bool($value)) {
            $this->results->push($value ? '1' : '0');
        } else {
            $this->results->push((string) $value);
        }
    }
}
