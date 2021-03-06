<?php

namespace Scato\Serializer\Xml;

use Scato\Serializer\Core\AbstractDeserializerFactory;
use Scato\Serializer\Core\DecoderInterface;
use Scato\Serializer\Core\NavigatorInterface;
use Scato\Serializer\Core\TypedVisitorInterface;
use Scato\Serializer\Navigation\ObjectFactoryInterface;
use Scato\Serializer\ObjectAccess\ReflectionTypeProvider;
use Scato\Serializer\ObjectAccess\SimpleObjectFactory;

/**
 * Creates an XML deserializer and all its components
 */
class XmlDeserializerFactory extends AbstractDeserializerFactory
{
    /**
     * @return NavigatorInterface
     */
    protected function createNavigator()
    {
        return new DOMNavigator(new DOMElementAccessor());
    }

    /**
     * @param ObjectFactoryInterface $objectFactory
     * @return TypedVisitorInterface
     */
    protected function createVisitor(ObjectFactoryInterface $objectFactory)
    {
        return new FromXmlVisitor($objectFactory, new ReflectionTypeProvider());
    }

    /**
     * @return DecoderInterface
     */
    protected function createDecoder()
    {
        return new XmlDecoder();
    }
}
