<?php

namespace Scato\Serializer\Php;

use Scato\Serializer\Core\Navigator;
use Scato\Serializer\Core\Type;
use Scato\Serializer\Core\TypedVisitorInterface;

class Mapper
{

    private $navigator;
    private $visitor;

    public function __construct(
        Navigator $navigator,
        TypedVisitorInterface $visitor
    ) {
        $this->navigator = $navigator;
        $this->visitor = $visitor;
    }

    public function map($value, $type)
    {
        $this->visitor->visitType(Type::fromString($type));

        $this->navigator->accept($this->visitor, $value);

        return $this->visitor->getResult();
    }
}
