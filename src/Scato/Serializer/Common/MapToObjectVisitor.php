<?php


namespace Scato\Serializer\Common;

use InvalidArgumentException;
use Scato\Serializer\Core\TypedVisitorInterface;

class MapToObjectVisitor extends ObjectToArrayVisitor implements TypedVisitorInterface
{
    protected $objectFactory;
    protected $typeProvider;

    private $types = array();

    public function __construct(ObjectFactoryInterface $objectFactory, TypeProviderInterface $typeProvider)
    {
        $this->objectFactory = $objectFactory;
        $this->typeProvider = $typeProvider;
    }

    public function visitType($type)
    {
        $this->pushType($type);
    }

    public function visitObjectEnd($class)
    {
        parent::visitArrayEnd();

        $type = $this->peekType(1);
        $array = $this->popResult();

        if ($type === null) {
            throw new InvalidArgumentException('Cannot create object because its type is unknown');
        }

        $object = $this->objectFactory->createObject($type, $array);

        $this->pushResult($object);
    }

    public function visitElementStart($key)
    {
        parent::visitElementStart($key);

        $type = $this->peekType(1);

        if ($type === null || $type === 'array') {
            $elementType = null;
        } else if (preg_match('/^(.*)\\[\\]$/', $type, $matches)) {
            $elementType = $matches[1];
        } else {
            $elementType = $this->typeProvider->getType($this->peekType(1), $key);
        }

        $this->pushType($elementType);
    }

    public function visitElementEnd($key)
    {
        $this->popType();

        parent::visitElementEnd($key);
    }

    protected function pushType($type)
    {
        array_push($this->types, $type);
    }

    protected function peekType($count)
    {
        return $this->types[count($this->types) - $count];
    }

    protected function popType()
    {
        return array_pop($this->types);
    }
}
