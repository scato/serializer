<?php

namespace Scato\Serializer\Json;

use Scato\Serializer\Core\AbstractDeserializerFactory;
use Scato\Serializer\Core\DecoderInterface;
use Scato\Serializer\Core\NavigatorInterface;
use Scato\Serializer\Core\TypedVisitorInterface;
use Scato\Serializer\Navigation\DeserializeVisitor;
use Scato\Serializer\Navigation\Navigator;
use Scato\Serializer\Navigation\ObjectFactoryInterface;
use Scato\Serializer\ObjectAccess\ReflectionTypeProvider;
use Scato\Serializer\ObjectAccess\SimpleAccessor;
use Scato\Serializer\ObjectAccess\SimpleObjectFactory;

/**
 * Creates a JSON deserializer and all its components
 */
class JsonDeserializerFactory extends AbstractDeserializerFactory
{
    /**
     * @return NavigatorInterface
     */
    protected function createNavigator()
    {
        return new Navigator(new SimpleAccessor());
    }

    /**
     * @param ObjectFactoryInterface $objectFactory
     * @return TypedVisitorInterface
     */
    protected function createVisitor(ObjectFactoryInterface $objectFactory)
    {
        return new DeserializeVisitor($objectFactory, new ReflectionTypeProvider());
    }

    /**
     * @return DecoderInterface
     */
    protected function createDecoder()
    {
        return new JsonDecoder();
    }
}
