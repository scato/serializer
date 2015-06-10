<?php

namespace Scato\Serializer\Xml;

use DOMDocument;
use Scato\Serializer\Core\DecoderInterface;

class XmlDecoder implements DecoderInterface
{

    public function decode($value)
    {
        $dom = new DOMDocument();
        $dom->loadXML($value);

        return $dom;
    }
}
