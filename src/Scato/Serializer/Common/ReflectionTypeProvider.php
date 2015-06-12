<?php

namespace Scato\Serializer\Common;

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Tag\VarTag;
use ReflectionClass;
use Scato\Serializer\Core\Type;

class ReflectionTypeProvider implements TypeProviderInterface
{
    public function getType(Type $class, $name)
    {
        $reflectionObject = new ReflectionClass($class->toString());

        if (!$reflectionObject->hasProperty($name)) {
            return Type::fromString(null);
        }

        $reflectionProperty = $reflectionObject->getProperty($name);

        $phpdoc = new DocBlock($reflectionProperty);

        /** @var VarTag[] $vars */
        $vars = $phpdoc->getTagsByName('var');

        if (count($vars) === 0) {
            return Type::fromString(null);
        }

        return Type::fromString($vars[0]->getType());
    }
}
