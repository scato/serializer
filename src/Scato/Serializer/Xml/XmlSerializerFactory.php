<?php

namespace Scato\Serializer\Xml;

use Scato\Serializer\Core\AbstractSerializerFactory;
use Scato\Serializer\Core\EncoderInterface;
use Scato\Serializer\Core\NavigatorInterface;
use Scato\Serializer\Core\VisitorInterface;
use Scato\Serializer\Navigation\Navigator;
use Scato\Serializer\ObjectAccess\SimpleAccessor;

class XmlSerializerFactory extends AbstractSerializerFactory
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
        return new ToXmlVisitor();
    }

    /**
     * @return EncoderInterface
     */
    protected function createEncoder()
    {
        return new XmlEncoder();
    }
}
