<?php

namespace Scato\Serializer\Common;

use phpDocumentor\Reflection\DocBlock;

class ReflectionTypeProvider implements TypeProviderInterface
{
    public function getType($class, $name)
    {
        $reflectionObject = new \ReflectionClass($class);

        if (!$reflectionObject->hasProperty($name)) {
            return null;
        }

        $reflectionProperty = $reflectionObject->getProperty($name);

        $phpdoc = new DocBlock($reflectionProperty);
        $vars = $phpdoc->getTagsByName('var');

        if (count($vars) === 0) {
            return null;
        }

        return $vars[0]->getType();
    }
}
