<?php

namespace Scato\Serializer\Data;

use Scato\Serializer\Core\Type;
use Scato\Serializer\Navigation\TypeProviderInterface;

/**
 * Decorates a TypeProvider so it can handle array types as well
 */
class ArrayTypeProviderDecorator implements TypeProviderInterface
{
    /**
     * @var TypeProviderInterface
     */
    private $parent;

    /**
     * @param TypeProviderInterface $parent
     */
    public function __construct(TypeProviderInterface $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Fetch the type of one property (or index)
     *
     * @param Type   $class
     * @param string $name
     * @return Type
     */
    public function getType(Type $class, $name)
    {
        if ($class->isArray()) {
            return $class->getElementType();
        }

        return $this->parent->getType($class, $name);
    }
}
