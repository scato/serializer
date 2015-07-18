<?php

namespace Scato\Serializer\Core;

/**
 * Creates a serializer and all its components
 */
abstract class AbstractSerializerFactory
{
    /**
     * @return Serializer
     */
    public function createSerializer()
    {
        return new Serializer(
            $this->createNavigator(),
            $this->createVisitor(),
            $this->createEncoder()
        );
    }

    /**
     * @return NavigatorInterface
     */
    abstract protected function createNavigator();

    /**
     * @return VisitorInterface
     */
    abstract protected function createVisitor();

    /**
     * @return EncoderInterface
     */
    abstract protected function createEncoder();
}
