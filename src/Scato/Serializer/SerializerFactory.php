<?php

namespace Scato\Serializer;

use Scato\Serializer\Common\MapToObjectVisitor;
use Scato\Serializer\Common\SimpleAccessor;
use Scato\Serializer\Common\ReflectionTypeProvider;
use Scato\Serializer\Common\SimpleObjectFactory;
use Scato\Serializer\Core\Deserializer;
use Scato\Serializer\Core\Navigator;
use Scato\Serializer\Core\Serializer;
use Scato\Serializer\Json\JsonDecoder;
use Scato\Serializer\Json\JsonEncoder;
use Scato\Serializer\Json\ToJsonVisitor;
use Scato\Serializer\Url\FromUrlVisitor;
use Scato\Serializer\Url\ToUrlVisitor;
use Scato\Serializer\Url\UrlDecoder;
use Scato\Serializer\Url\UrlEncoder;

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
            new MapToObjectVisitor(
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
}
