<?php

namespace Scato\Serializer\Core;

abstract class AbstractDeserializerFactory
{
    /**
     * @return Deserializer
     */
    public function createDeserializer()
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
