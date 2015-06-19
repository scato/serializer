<?php

namespace Scato\Serializer\Data;

use ReflectionMethod;
use ReflectionObject;
use Scato\Serializer\Core\ObjectAccessorInterface;

class GetterAccessorDecorator implements ObjectAccessorInterface
{
    private $parent;

    public function __construct(ObjectAccessorInterface $parent)
    {
        $this->parent = $parent;
    }

    public function getNames($object)
    {
        $reflectionObject = new ReflectionObject($object);

        return array_merge(
            $this->parent->getNames($object),
            array_map(function (ReflectionMethod $reflectionMethod) {
                return lcfirst(preg_replace('/^get/', '', $reflectionMethod->getName()));
            }, array_filter($reflectionObject->getMethods(), function (ReflectionMethod $reflectionMethod) {
                return $reflectionMethod->isPublic()
                    && !$reflectionMethod->isStatic()
                    && preg_match('/^get/', $reflectionMethod->getName());
            }))
        );
    }

    public function getValue($object, $name)
    {
        $getter = 'get' . ucfirst($name);

        if (is_callable(array($object, $getter))) {
            return $object->$getter();
        }

        return $this->parent->getValue($object, $name);
    }
}
