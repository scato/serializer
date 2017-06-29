<?php

namespace Scato\Serializer;

use Scato\Serializer\Data\DataMapperFactory;
use Scato\Serializer\Navigation\DeserializationFilterInterface;
use Scato\Serializer\Navigation\SerializationConverterInterface;

/**
 * Maps values
 */
class MapperFacade
{
    /**
     * @var DataMapperFactory
     */
    private $mapperFactory;

    /**
     * @var SerializationConverterInterface[]
     */
    private $converters = [];

    /**
     * @var DeserializationFilterInterface[]
     */
    private $filters = [];

    /**
     * @param DataMapperFactory $mapperFactory
     */
    public function __construct(DataMapperFactory $mapperFactory)
    {
        $this->mapperFactory = $mapperFactory;
    }

    /**
     * @return MapperFacade
     */
    public static function create()
    {
        return new self(
            new DataMapperFactory()
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
     * @param string $type
     * @return mixed
     */
    public function map($value, $type)
    {
        $mapper = $this->mapperFactory->createMapper($this->converters, $this->filters);

        return $mapper->map($value, $type);
    }
}
