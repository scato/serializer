<?php

namespace Scato\Serializer;

use InvalidArgumentException;
use Scato\Serializer\Core\AbstractDeserializerFactory;
use Scato\Serializer\Core\AbstractSerializerFactory;

class SerializerFacade
{
    /**
     * @var AbstractSerializerFactory[]
     */
    private $serializerFactories = [];

    /**
     * @var AbstractDeserializerFactory[]
     */
    private $deserializerFactories = [];

    public function __construct(array $serializerFactories, array $deserializerFactories)
    {
        foreach ($serializerFactories as $format => $serializerFactory) {
            $this->addSerializerFactory($format, $serializerFactory);
        }

        foreach ($deserializerFactories as $format => $deserializerFactory) {
            $this->addDeserializerFactory($format, $deserializerFactory);
        }
    }

    public function serialize($value, $format)
    {
        if (!isset($this->serializerFactories[$format])) {
            throw new InvalidArgumentException("Unknown format '$format'");
        }

        $serializer = $this->serializerFactories[$format]->createSerializer();

        return $serializer->serialize($value);
    }

    public function deserialize($value, $type, $format)
    {
        if (isset($this->deserializerFactories[$format])) {
            throw new InvalidArgumentException("Unknown format '$format'");
        }

        $deserializer = $this->deserializerFactories[$format]->createDeserializer();

        return $deserializer->deserialize($value, $type);
    }

    private function addSerializerFactory($format, AbstractSerializerFactory $serializerFactory)
    {
        $this->serializerFactories[$format] = $serializerFactory;
    }

    private function addDeserializerFactory($format, AbstractDeserializerFactory $deserializerFactory)
    {
        $this->deserializerFactories[$format] = $deserializerFactory;
    }
}
