<?php

namespace Scato\Serializer\Common;

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Tag\VarTag;
use phpDocumentor\Reflection\Types\Context;
use phpDocumentor\Reflection\Types\ContextFactory;
use ReflectionClass;
use Scato\Serializer\Core\Type;

/**
 * Provides property types using the var docblock tag
 */
class ReflectionTypeProvider implements TypeProviderInterface
{
    /**
     * {@inheritdoc}
     *
     * @param Type   $class
     * @param string $name
     * @return Type
     */
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

    /**
     * Convert TypeResolver Context to DocBlock Context
     *
     * @param Context $context
     * @return DocBlock\Context
     */
    private function convertToDocBlockContext(Context $context)
    {
        return new DocBlock\Context(
            $context->getNamespace(),
            $context->getNamespaceAliases()
        );
    }
}
