<?php

namespace Scato\Serializer\Data;

use Scato\Serializer\Core\NavigatorInterface;
use Scato\Serializer\Core\Type;
use Scato\Serializer\Core\TypedVisitorInterface;

/**
 * Turns an object graph into another object graph
 */
class Mapper
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
     * @param NavigatorInterface    $navigator
     * @param TypedVisitorInterface $visitor
     */
    public function __construct(NavigatorInterface $navigator, TypedVisitorInterface $visitor)
    {
        $this->navigator = $navigator;
        $this->visitor = $visitor;
    }

    /**
     * Turn an object graph into another object graph
     *
     * @param mixed  $value
     * @param string $type
     * @return mixed
     */
    public function map($value, $type)
    {
        $this->visitor->visitType(Type::fromString($type));

        $this->navigator->accept($this->visitor, $value);

        return $this->visitor->getResult();
    }
}
