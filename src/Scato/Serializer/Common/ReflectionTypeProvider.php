<?php

namespace Scato\Serializer\Common;

use phpDocumentor\Reflection\DocBlock;

class ReflectionTypeProvider implements TypeProviderInterface
{
    public function getType($object, $name)
    {
        $reflectionObject = new \ReflectionObject($object);

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
