<?php

namespace Scato\Serializer\Core;

/**
 * Turns an object graph into a string
 */
class Serializer
{
    /**
     * @var Navigator
     */
    private $navigator;

    /**
     * @var VisitorInterface
     */
    private $visitor;

    /**
     * @var EncoderInterface
     */
    private $encoder;

    /**
     * @param Navigator        $navigator
     * @param VisitorInterface $visitor
     * @param EncoderInterface $encoder
     */
    public function __construct(
        Navigator $navigator,
        VisitorInterface $visitor,
        EncoderInterface $encoder
    ) {
        $this->navigator = $navigator;
        $this->visitor = $visitor;
        $this->encoder = $encoder;
    }

    /**
     * Turn an object graph into a string
     *
     * @param mixed $value
     * @return string
     */
    public function serialize($value)
    {
        $this->navigator->accept($this->visitor, $value);

        $result = $this->visitor->getResult();

        return $this->encoder->encode($result);
    }
}
