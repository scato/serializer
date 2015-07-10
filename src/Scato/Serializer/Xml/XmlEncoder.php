<?php

namespace Scato\Serializer\Xml;

use DOMDocument;
use InvalidArgumentException;
use Scato\Serializer\Core\EncoderInterface;

/**
 * Encodes XML strings
 */
class XmlEncoder implements EncoderInterface
{
    /**
     * Turn DOMDocument into XML string
     *
     * @param mixed $value
     * @return string
     * @throws InvalidArgumentException
     */
    public function encode($value)
    {
        if (!($value instanceof DOMDocument)) {
            throw new InvalidArgumentException("XmlEncoder only accepts values of type DOMDocument");
        }

        return $value->saveXML();
    }
}
