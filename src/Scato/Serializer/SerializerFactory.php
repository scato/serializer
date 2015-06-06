<?php

namespace Scato\Serializer;

use Scato\Serializer\Common\PublicAccessor;
use Scato\Serializer\Common\ReflectionTypeProvider;
use Scato\Serializer\Core\Deserializer;
use Scato\Serializer\Core\Navigator;
use Scato\Serializer\Core\Serializer;
use Scato\Serializer\Json\JsonDecoder;
use Scato\Serializer\Json\JsonEncoder;
use Scato\Serializer\Json\FromJsonVisitor;
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
                new PublicAccessor()
            ),
            new ToJsonVisitor(
                new PublicAccessor()
            ),
            new JsonEncoder()
        );
    }

    public function createJsonDeserializer()
    {
        return new Deserializer(
            new Navigator(
                new PublicAccessor()
            ),
            new FromJsonVisitor(
                new PublicAccessor(),
                new ReflectionTypeProvider()
            ),
            new JsonDecoder()
        );
    }

    public function createUrlSerializer()
    {
        return new Serializer(
            new Navigator(
                new PublicAccessor()
            ),
            new ToUrlVisitor(
                new PublicAccessor()
            ),
            new UrlEncoder()
        );
    }

    public function createUrlDeserializer()
    {
        return new Deserializer(
            new Navigator(
                new PublicAccessor()
            ),
            new FromUrlVisitor(
                new PublicAccessor(),
                new ReflectionTypeProvider()
            ),
            new UrlDecoder()
        );
    }
}
