<?php

namespace Scato\Serializer;

use InvalidArgumentException;
use Scato\Serializer\Core\AbstractDeserializerFactory;
use Scato\Serializer\Core\AbstractSerializerFactory;

/**
 * Serializes, deserializes and maps values
 */
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

    /**
     * @param array|AbstractSerializerFactory[]   $serializerFactories
     * @param array|AbstractDeserializerFactory[] $deserializerFactories
     */
    public function __construct(array $serializerFactories, array $deserializerFactories)
    {
        foreach ($serializerFactories as $format => $serializerFactory) {
            $this->addSerializerFactory($format, $serializerFactory);
        }

        foreach ($deserializerFactories as $format => $deserializerFactory) {
            $this->addDeserializerFactory($format, $deserializerFactory);
        }
    }

    /**
     * @param mixed  $value
     * @param string $format
     * @return string
     * @throws InvalidArgumentException
     */
    public function serialize($value, $format)
    {
        if (!isset($this->serializerFactories[$format])) {
            throw new InvalidArgumentException("Unknown format '$format'");
        }

        $serializer = $this->serializerFactories[$format]->createSerializer();

        return $serializer->serialize($value);
    }

    /**
     * @param string $value
     * @param string $type
     * @param string $format
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function deserialize($value, $type, $format)
    {
        if (isset($this->deserializerFactories[$format])) {
            throw new InvalidArgumentException("Unknown format '$format'");
        }

        $deserializer = $this->deserializerFactories[$format]->createDeserializer();

        return $deserializer->deserialize($value, $type);
    }

    /**
     * @param string                    $format
     * @param AbstractSerializerFactory $serializerFactory
     * @return void
     */
    private function addSerializerFactory($format, AbstractSerializerFactory $serializerFactory)
    {
        $this->serializerFactories[$format] = $serializerFactory;
    }

    /**
     * @param string                      $format
     * @param AbstractDeserializerFactory $deserializerFactory
     * @return void
     */
    private function addDeserializerFactory($format, AbstractDeserializerFactory $deserializerFactory)
    {
        $this->deserializerFactories[$format] = $deserializerFactory;
    }
}
