<?php

use Behat\Behat\Context\Context;
use Scato\Serializer\Data\DataMapperFactory;
use Scato\Serializer\MapperFacade;
use Scato\Serializer\Navigation\DeserializationFilterInterface;
use Scato\Serializer\Navigation\SerializationConverterInterface;
use Scato\Serializer\SerializerFacade;

/**
 * Defines steps that drive the serializers (and the data mapper)
 */
class SerializerContext implements Context
{
    /**
     * @var mixed
     */
    protected $input;

    /**
     * @var mixed
     */
    protected $output;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var SerializationConverterInterface[]
     */
    protected $converters = [];

    /**
     * @var DeserializationFilterInterface[]
     */
    protected $filters = [];

    /**
     * @When I serialize it to :format
     */
    public function iSerializeItTo($format)
    {
        $serializer = SerializerFacade::create();

        foreach ($this->converters as $converter) {
            $serializer->addSerializationConverter($converter);
        }

        $this->format = $format;
        $this->output = $serializer->serialize($this->input, strtolower($format));
    }

    /**
     * @When I deserialize it
     */
    public function iDeserializeIt()
    {
        $serializer = SerializerFacade::create();

        foreach ($this->filters as $filter) {
            $serializer->addDeserializationFilter($filter);
        }

        $this->output = $serializer->deserialize($this->input, $this->class, strtolower($this->format));
    }

    /**
     * @When I map it to :type
     */
    public function iMapItTo($type)
    {
        $mapper = MapperFacade::create();

        foreach ($this->converters as $converter) {
            $mapper->addSerializationConverter($converter);
        }

        foreach ($this->filters as $filter) {
            $mapper->addDeserializationFilter($filter);
        }

        $this->format = 'PHP';
        $this->output = $mapper->map($this->input, $type);
    }
}