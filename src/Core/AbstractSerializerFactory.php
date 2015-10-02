<?php

namespace Scato\Serializer\Core;

use Scato\Serializer\Navigation\SerializationConverterInterface;
use Scato\Serializer\Navigation\ConversionNavigatorDecorator;

/**
 * Creates a serializer and all its components
 */
abstract class AbstractSerializerFactory
{
    /**
     * @param SerializationConverterInterface[] $converters
     * @return Serializer
     */
    public function createSerializer(array $converters = [])
    {
        $navigator = $this->createNavigator();

        foreach ($converters as $converter) {
            $navigator = new ConversionNavigatorDecorator($navigator, $converter);
        }

        return new Serializer(
            $navigator,
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
