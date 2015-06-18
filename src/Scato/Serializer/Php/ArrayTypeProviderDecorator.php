<?php

namespace Scato\Serializer\Php;

use Scato\Serializer\Common\TypeProviderInterface;
use Scato\Serializer\Core\Type;

class ArrayTypeProviderDecorator implements TypeProviderInterface
{
    private $parent;

    public function __construct(TypeProviderInterface $parent)
    {
        $this->parent = $parent;
    }

    public function getType(Type $class, $name)
    {
        if ($class->isArray()) {
            return $class->getElementType();
        }

        return $this->parent->getType($class, $name);
    }
}
