<?php

namespace Scato\Serializer\Core;

use Scato\Serializer\Navigation\DeserializationFilterInterface;
use Scato\Serializer\Navigation\FilteringObjectFactoryDecorator;
use Scato\Serializer\Navigation\ObjectFactoryInterface;
use Scato\Serializer\ObjectAccess\SimpleObjectFactory;

/**
 * Creates a deserializer and all its components
 */
abstract class AbstractDeserializerFactory
{
    /**
     * @param DeserializationFilterInterface[] $filters
     * @return Deserializer
     */
    public function createDeserializer(array $filters = [])
    {
        $objectFactory = new SimpleObjectFactory();

        foreach ($filters as $filter) {
            $objectFactory = new FilteringObjectFactoryDecorator($objectFactory, $filter);
        }

        return new Deserializer(
            $this->createNavigator(),
            $this->createVisitor($objectFactory),
            $this->createDecoder()
        );
    }

    /**
     * @return NavigatorInterface
     */
    abstract protected function createNavigator();

    /**
     * @param ObjectFactoryInterface $objectFactory
     * @return TypedVisitorInterface
     */
    abstract protected function createVisitor(ObjectFactoryInterface $objectFactory);

    /**
     * @return DecoderInterface
     */
    abstract protected function createDecoder();
}
