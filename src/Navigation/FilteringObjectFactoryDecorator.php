<?php

namespace Scato\Serializer\Navigation;

use Scato\Serializer\Core\Type;

/**
 * Wraps around an ObjectFactory, either overriding or delegating object creation
 */
class FilteringObjectFactoryDecorator implements ObjectFactoryInterface
{
    /**
     * @var ObjectFactoryInterface
     */
    private $objectFactory;

    /**
     * @var DeserializationFilterInterface
     */
    private $filter;

    /**
     * @param ObjectFactoryInterface         $objectFactory
     * @param DeserializationFilterInterface $filter
     */
    public function __construct(ObjectFactoryInterface $objectFactory, DeserializationFilterInterface $filter)
    {
        $this->objectFactory = $objectFactory;
        $this->filter = $filter;
    }

    /**
     * @param Type  $type
     * @param mixed $value
     * @return mixed
     */
    public function createObject(Type $type, $value)
    {
        return $this->filter->filter($type, $value, $this->objectFactory);
    }
}
