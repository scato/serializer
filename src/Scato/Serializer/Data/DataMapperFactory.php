<?php

namespace Scato\Serializer\Data;

use Scato\Serializer\Core\NavigatorInterface;
use Scato\Serializer\Core\TypedVisitorInterface;
use Scato\Serializer\Navigation\DeserializeVisitor;
use Scato\Serializer\Navigation\Navigator;
use Scato\Serializer\ObjectAccess\ReflectionTypeProvider;
use Scato\Serializer\ObjectAccess\SimpleAccessor;
use Scato\Serializer\ObjectAccess\SimpleObjectFactory;

class DataMapperFactory
{
    /**
     * @return Mapper
     */
    public function createMapper()
    {
        return new Mapper($this->createNavigator(), $this->createVisitor());
    }

    /**
     * @return NavigatorInterface
     */
    protected function createNavigator()
    {
        return new Navigator(new SimpleAccessor());
    }

    /**
     * @return TypedVisitorInterface
     */
    protected function createVisitor()
    {
        return new DeserializeVisitor(new SimpleObjectFactory(), new ReflectionTypeProvider());
    }
}
