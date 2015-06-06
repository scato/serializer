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
}
