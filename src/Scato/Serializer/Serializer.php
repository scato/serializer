<?php

namespace Scato\Serializer;

class Serializer
{

    private $navigator;
    private $visitor;
    private $encoder;

    public function __construct(
        Navigator $navigator,
        ValueVisitorInterface $visitor,
        EncoderInterface $encoder
    ) {
        $this->navigator = $navigator;
        $this->visitor = $visitor;
        $this->encoder = $encoder;
    }

    public function serialize($value)
    {
        $this->navigator->accept($this->visitor, $value);

        $result = $this->visitor->getResult();

        return $this->encoder->encode($result);
    }
}
