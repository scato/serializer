<?php

namespace Scato\Serializer\Xml;

use DOMDocument;
use Scato\Serializer\Core\DecoderInterface;

/**
 * Decodes XML strings
 */
class XmlDecoder implements DecoderInterface
{
    /**
     * Turn XML string into DOMDocument
     *
     * @param string $value
     * @return DOMDocument
     */
    public function decode($value)
    {
        $dom = new DOMDocument();
        $dom->loadXML($value);

        return $dom;
    }
}
