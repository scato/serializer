<?php

namespace Scato\Serializer\Core;

use Scato\Serializer\Navigation\DeserializationFilterInterface;

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
        return new Deserializer(
            $this->createNavigator(),
            $this->createVisitor(),
            $this->createDecoder()
        );
    }

    /**
     * @return NavigatorInterface
     */
    abstract protected function createNavigator();

    /**
     * @return TypedVisitorInterface
     */
    abstract protected function createVisitor();

    /**
     * @return DecoderInterface
     */
    abstract protected function createDecoder();
}
