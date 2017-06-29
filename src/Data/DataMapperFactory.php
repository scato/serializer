<?php

namespace Scato\Serializer\Data;

use Scato\Serializer\Core\NavigatorInterface;
use Scato\Serializer\Core\TypedVisitorInterface;
use Scato\Serializer\Navigation\ConversionNavigatorDecorator;
use Scato\Serializer\Navigation\DeserializationFilterInterface;
use Scato\Serializer\Navigation\DeserializeVisitor;
use Scato\Serializer\Navigation\FilteringObjectFactoryDecorator;
use Scato\Serializer\Navigation\Navigator;
use Scato\Serializer\Navigation\ObjectFactoryInterface;
use Scato\Serializer\Navigation\SerializationConverterInterface;
use Scato\Serializer\ObjectAccess\ReflectionTypeProvider;
use Scato\Serializer\ObjectAccess\SimpleAccessor;
use Scato\Serializer\ObjectAccess\SimpleObjectFactory;

/**
 * Creates a data mapper and all its components
 */
class DataMapperFactory
{
    /**
     * @param SerializationConverterInterface[] $converters
     * @param DeserializationFilterInterface[]  $filters
     * @return Mapper
     */
    public function createMapper(array $converters = [], array $filters = [])
    {
        $navigator = $this->createNavigator();

        foreach ($converters as $converter) {
            $navigator = new ConversionNavigatorDecorator($navigator, $converter);
        }

        $objectFactory = new SimpleObjectFactory();

        foreach ($filters as $filter) {
            $objectFactory = new FilteringObjectFactoryDecorator($objectFactory, $filter);
        }

        return new Mapper(
            $navigator,
            $this->createVisitor($objectFactory)
        );
    }

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
}
