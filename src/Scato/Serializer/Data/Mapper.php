<?php

namespace Scato\Serializer\Data;

use Scato\Serializer\Core\Navigator;
use Scato\Serializer\Core\Type;
use Scato\Serializer\Core\TypedVisitorInterface;

/**
 * Turns an object graph into another object graph
 */
class Mapper
{
    /**
     * @var Navigator
     */
    private $navigator;

    /**
     * @var TypedVisitorInterface
     */
    private $visitor;

    /**
     * @param Navigator             $navigator
     * @param TypedVisitorInterface $visitor
     */
    public function __construct(Navigator $navigator, TypedVisitorInterface $visitor)
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
