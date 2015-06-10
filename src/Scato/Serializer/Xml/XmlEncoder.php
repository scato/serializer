<?php

namespace Scato\Serializer\Xml;

use DOMDocument;
use InvalidArgumentException;
use Scato\Serializer\Core\EncoderInterface;

class XmlEncoder implements EncoderInterface
{
    public function encode($value)
    {
        if (!($value instanceof DOMDocument)) {
            throw new InvalidArgumentException("XmlEncoder only accepts values of type DOMDocument");
        }

        return $value->saveXML();
    }
}
