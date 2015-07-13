<?php

namespace Scato\Serializer;

use Scato\Serializer\Data\DataMapperFactory;
use Scato\Serializer\Json\JsonDeserializerFactory;
use Scato\Serializer\Json\JsonSerializerFactory;
use Scato\Serializer\Core\Deserializer;
use Scato\Serializer\Core\Serializer;
use Scato\Serializer\Data\Mapper;
use Scato\Serializer\Url\UrlDeserializerFactory;
use Scato\Serializer\Url\UrlSerializerFactory;
use Scato\Serializer\Xml\XmlDeserializerFactory;
use Scato\Serializer\Xml\XmlSerializerFactory;

/**
 * Creates serializers, deserializers and mappers for all formats
 */
class SerializerFactory
{
    /**
     * @var JsonSerializerFactory
     */
    private $jsonSerializerFactory;

    /**
     * @var JsonDeserializerFactory
     */
    private $jsonDeserializerFactory;

    /**
     * @var UrlSerializerFactory
     */
    private $urlSerializerFactory;

    /**
     * @var UrlDeserializerFactory
     */
    private $urlDeserializerFactory;

    /**
     * @var XmlSerializerFactory
     */
    private $xmlSerializerFactory;

    /**
     * @var XmlDeserializerFactory
     */
    private $xmlDeserializerFactory;

    /**
     * @var DataMapperFactory
     */
    private $dataMapperFactory;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->jsonSerializerFactory = new JsonSerializerFactory();
        $this->jsonDeserializerFactory = new JsonDeserializerFactory();
        $this->urlSerializerFactory = new UrlSerializerFactory();
        $this->urlDeserializerFactory = new UrlDeserializerFactory();
        $this->xmlSerializerFactory = new XmlSerializerFactory();
        $this->xmlDeserializerFactory = new XmlDeserializerFactory();
        $this->dataMapperFactory = new DataMapperFactory();
    }

    /**
     * @return Serializer
     */
    public function createJsonSerializer()
    {
        return $this->jsonSerializerFactory->createSerializer();
    }

    /**
     * @return Deserializer
     */
    public function createJsonDeserializer()
    {
        return $this->jsonDeserializerFactory->createDeserializer();
    }

    /**
     * @return Serializer
     */
    public function createUrlSerializer()
    {
        return $this->urlSerializerFactory->createSerializer();
    }

    /**
     * @return Deserializer
     */
    public function createUrlDeserializer()
    {
        return $this->urlDeserializerFactory->createDeserializer();
    }

    /**
     * @return Serializer
     */
    public function createXmlSerializer()
    {
        return $this->xmlSerializerFactory->createSerializer();
    }

    /**
     * @return Deserializer
     */
    public function createXmlDeserializer()
    {
        return $this->xmlDeserializerFactory->createDeserializer();
    }

    /**
     * @return Mapper
     */
    public function createDataMapper()
    {
        return $this->dataMapperFactory->createMapper();
    }
}
