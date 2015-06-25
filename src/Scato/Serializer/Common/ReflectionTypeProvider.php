<?php

namespace Scato\Serializer\Common;

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Tag\VarTag;
use phpDocumentor\Reflection\Types\Context;
use phpDocumentor\Reflection\Types\ContextFactory;
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

        $contextFactory = new ContextFactory();
        $context = $contextFactory->createFromReflector($reflectionProperty);

        $phpdoc = new DocBlock($reflectionProperty, $this->convertToDocBlockContext($context));

        /** @var VarTag[] $vars */
        $vars = $phpdoc->getTagsByName('var');

        if (count($vars) === 0) {
            return Type::fromString(null);
        }

        return Type::fromString($vars[0]->getType());
    }

    private function convertToDocBlockContext(Context $context)
    {
        return new DocBlock\Context(
            $context->getNamespace(),
            $context->getNamespaceAliases()
        );
    }
}
