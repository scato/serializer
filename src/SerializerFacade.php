<?php

namespace Scato\Serializer;

use InvalidArgumentException;
use Scato\Serializer\Core\AbstractDeserializerFactory;
use Scato\Serializer\Core\AbstractSerializerFactory;
use Scato\Serializer\Json\JsonDeserializerFactory;
use Scato\Serializer\Json\JsonSerializerFactory;
use Scato\Serializer\Navigation\DeserializationFilterInterface;
use Scato\Serializer\Navigation\SerializationConverterInterface;
use Scato\Serializer\Url\UrlDeserializerFactory;
use Scato\Serializer\Url\UrlSerializerFactory;
use Scato\Serializer\Xml\XmlDeserializerFactory;
use Scato\Serializer\Xml\XmlSerializerFactory;

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
     * @var SerializationConverterInterface[]
     */
    private $converters = [];

    /**
     * @var DeserializationFilterInterface[]
     */
    private $filters = [];

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
     * @return SerializerFacade
     */
    public static function create()
    {
        return new self(
            array(
                'json' => new JsonSerializerFactory(),
                'url' => new UrlSerializerFactory(),
                'xml' => new XmlSerializerFactory(),
            ),
            array(
                'json' => new JsonDeserializerFactory(),
                'url' => new UrlDeserializerFactory(),
                'xml' => new XmlDeserializerFactory(),
            )
        );
    }

    /**
     * @param SerializationConverterInterface $converter
     * @return void
     */
    public function addSerializationConverter(SerializationConverterInterface $converter)
    {
        $this->converters[] = $converter;
    }

    /**
     * @param DeserializationFilterInterface $filter
     * @return void
     */
    public function addDeserializationFilter(DeserializationFilterInterface $filter)
    {
        $this->filters[] = $filter;
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

        $serializer = $this->serializerFactories[$format]->createSerializer($this->converters);

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
        if (!isset($this->deserializerFactories[$format])) {
            throw new InvalidArgumentException("Unknown format '$format'");
        }

        $deserializer = $this->deserializerFactories[$format]->createDeserializer($this->filters);

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
