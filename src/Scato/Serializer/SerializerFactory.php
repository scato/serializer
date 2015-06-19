<?php

namespace Scato\Serializer;

use Scato\Serializer\Common\DeserializeVisitor;
use Scato\Serializer\Common\SimpleAccessor;
use Scato\Serializer\Common\ReflectionTypeProvider;
use Scato\Serializer\Common\SimpleObjectFactory;
use Scato\Serializer\Core\Deserializer;
use Scato\Serializer\Core\Navigator;
use Scato\Serializer\Core\Serializer;
use Scato\Serializer\Data\ArrayTypeProviderDecorator;
use Scato\Serializer\Data\GetterAccessorDecorator;
use Scato\Serializer\Data\Mapper;
use Scato\Serializer\Data\SafeObjectFactory;
use Scato\Serializer\Json\JsonDecoder;
use Scato\Serializer\Json\JsonEncoder;
use Scato\Serializer\Json\ToJsonVisitor;
use Scato\Serializer\Url\FromUrlVisitor;
use Scato\Serializer\Url\ToUrlVisitor;
use Scato\Serializer\Url\UrlDecoder;
use Scato\Serializer\Url\UrlEncoder;
use Scato\Serializer\Xml\DOMElementAccessor;
use Scato\Serializer\Xml\FromXmlVisitor;
use Scato\Serializer\Xml\ToXmlVisitor;
use Scato\Serializer\Xml\XmlDecoder;
use Scato\Serializer\Xml\XmlEncoder;

class SerializerFactory
{

    public function createJsonSerializer()
    {
        return new Serializer(
            new Navigator(
                new SimpleAccessor()
            ),
            new ToJsonVisitor(),
            new JsonEncoder()
        );
    }

    public function createJsonDeserializer()
    {
        return new Deserializer(
            new Navigator(
                new SimpleAccessor()
            ),
            new DeserializeVisitor(
                new SimpleObjectFactory(),
                new ReflectionTypeProvider()
            ),
            new JsonDecoder()
        );
    }

    public function createUrlSerializer()
    {
        return new Serializer(
            new Navigator(
                new SimpleAccessor()
            ),
            new ToUrlVisitor(),
            new UrlEncoder()
        );
    }

    public function createUrlDeserializer()
    {
        return new Deserializer(
            new Navigator(
                new SimpleAccessor()
            ),
            new FromUrlVisitor(
                new SimpleObjectFactory(),
                new ReflectionTypeProvider()
            ),
            new UrlDecoder()
        );
    }

    public function createXmlSerializer()
    {
        return new Serializer(
            new Navigator(
                new SimpleAccessor()
            ),
            new ToXmlVisitor(),
            new XmlEncoder()
        );
    }

    public function createXmlDeserializer()
    {
        return new Deserializer(
            new Navigator(
                new DOMElementAccessor()
            ),
            new FromXmlVisitor(
                new SimpleObjectFactory(),
                new ReflectionTypeProvider()
            ),
            new XmlDecoder()
        );
    }

    public function createMapper()
    {
        return new Mapper(
            new Navigator(
                new GetterAccessorDecorator(new SimpleAccessor())
            ),
            new FromUrlVisitor(
                new SafeObjectFactory(),
                new ArrayTypeProviderDecorator(new ReflectionTypeProvider())
            )
        );
    }
}
