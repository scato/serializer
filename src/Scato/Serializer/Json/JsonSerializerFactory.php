<?php

namespace Scato\Serializer\Json;

use Scato\Serializer\Core\AbstractSerializerFactory;
use Scato\Serializer\Core\EncoderInterface;
use Scato\Serializer\Core\NavigatorInterface;
use Scato\Serializer\Core\VisitorInterface;
use Scato\Serializer\Navigation\Navigator;
use Scato\Serializer\Navigation\SerializeVisitor;
use Scato\Serializer\ObjectAccess\SimpleAccessor;

class JsonSerializerFactory extends AbstractSerializerFactory
{
    /**
     * @return NavigatorInterface
     */
    protected function createNavigator()
    {
        return new Navigator(new SimpleAccessor());
    }

    /**
     * @return VisitorInterface
     */
    protected function createVisitor()
    {
        return new SerializeVisitor();
    }

    /**
     * @return EncoderInterface
     */
    protected function createEncoder()
    {
        return new JsonEncoder();
    }
}
