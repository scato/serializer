<?php

use Behat\Behat\Context\Context;
use Scato\Serializer\Data\DataMapperFactory;
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
     * @var SerializationConverterInterface[]
     */
    protected $converters = [];

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
        $class = 'Fixtures\Person';

        $this->output = $serializer->deserialize($this->input, $class, strtolower($this->format));
    }

    /**
     * @When I deserialize it to :class
     */
    public function iDeserializeItTo($class)
    {
        $serializer = SerializerFacade::create();

        $this->output = $serializer->deserialize($this->input, $class, strtolower($this->format));
    }

    /**
     * @When I map it to :type
     */
    public function iMapItTo($type)
    {
        $factory = new DataMapperFactory();

        $this->output = $factory->createMapper()->map($this->input, $type);
    }
}