<?php

namespace Scato\Serializer\Core;

/**
 * Turns a string into an object graph
 */
class Deserializer
{
    /**
     * @var NavigatorInterface
     */
    private $navigator;

    /**
     * @var TypedVisitorInterface
     */
    private $visitor;

    /**
     * @var DecoderInterface
     */
    private $decoder;

    /**
     * @param NavigatorInterface    $navigator
     * @param TypedVisitorInterface $visitor
     * @param DecoderInterface      $decoder
     */
    public function __construct(
        NavigatorInterface $navigator,
        TypedVisitorInterface $visitor,
        DecoderInterface $decoder
    ) {
        $this->navigator = $navigator;
        $this->visitor = $visitor;
        $this->decoder = $decoder;
    }

    /**
     * Turn a string into an object graph
     *
     * @param string $string
     * @param string $type
     * @return mixed
     */
    public function deserialize($string, $type)
    {
        $this->visitor->visitType(Type::fromString($type));

        $value = $this->decoder->decode($string);

        $this->navigator->accept($this->visitor, $value);

        return $this->visitor->getResult();
    }
}
