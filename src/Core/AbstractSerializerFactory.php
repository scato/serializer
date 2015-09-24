<?php

namespace Scato\Serializer\Core;

use Scato\Serializer\Navigation\FilterInterface;
use Scato\Serializer\Navigation\FilterNavigatorDecorator;

/**
 * Creates a serializer and all its components
 */
abstract class AbstractSerializerFactory
{
    /**
     * @param FilterInterface[] $filters
     * @return Serializer
     */
    public function createSerializer(array $filters = [])
    {
        $navigator = $this->createNavigator();

        foreach ($filters as $filter) {
            $navigator = new FilterNavigatorDecorator($navigator, $filter);
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
