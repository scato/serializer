<?php

namespace Scato\Serializer;

class Deserializer
{

    private $navigator;
    private $visitor;
    private $decoder;

    public function __construct(
        Navigator $navigator,
        TypedValueVisitorInterface $visitor,
        DecoderInterface $decoder
    ) {
        $this->navigator = $navigator;
        $this->visitor = $visitor;
        $this->decoder = $decoder;
    }

    public function deserialize($string, $type)
    {
        $this->visitor->visitType($type);

        $value = $this->decoder->decode($string);

        $this->navigator->accept($this->visitor, $value);

        return $this->visitor->getResult();
    }
}
