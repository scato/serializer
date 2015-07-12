<?php

namespace Scato\Serializer\Xml;

use Scato\Serializer\Core\AbstractDeserializerFactory;
use Scato\Serializer\Core\DecoderInterface;
use Scato\Serializer\Core\NavigatorInterface;
use Scato\Serializer\Core\TypedVisitorInterface;
use Scato\Serializer\ObjectAccess\ReflectionTypeProvider;
use Scato\Serializer\ObjectAccess\SimpleObjectFactory;

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
     * @return TypedVisitorInterface
     */
    protected function createVisitor()
    {
        return new FromXmlVisitor(new SimpleObjectFactory(), new ReflectionTypeProvider());
    }

    /**
     * @return DecoderInterface
     */
    protected function createDecoder()
    {
        return new XmlDecoder();
    }
}
