<?php


namespace Scato\Serializer\Common;


use Scato\Serializer\Core\ObjectAccessorInterface;
use Scato\Serializer\Core\TypedVisitorInterface;

class MapToObjectVisitor extends ObjectToArrayVisitor implements TypedVisitorInterface
{
    protected $objectAccessor;
    protected $typeProvider;

    private $types = array();

    public function __construct(ObjectAccessorInterface $objectAccessor, TypeProviderInterface $typeProvider)
    {
        $this->objectAccessor = $objectAccessor;
        $this->typeProvider = $typeProvider;
    }

    public function visitType($type)
    {
        $this->pushType($type);
    }

    public function visitObjectStart($class)
    {
        $type = $this->peekType(1);

        if ($type === null) {
            $type = 'stdClass';
        }

        $reflection = new \ReflectionClass($type);
        $object = $reflection->newInstanceWithoutConstructor();

        $this->pushResult($object);
    }

    public function visitObjectEnd($class)
    {
    }

    public function visitPropertyStart($name)
    {
        parent::visitPropertyStart($name);

        $object = $this->peekResult(1);
        $type = $this->typeProvider->getType($object, $name);

        $this->pushType($type);
    }

    public function visitPropertyEnd($name)
    {
        $this->popType();

        $property = $this->popResult();
        $object = $this->popResult();

        $this->objectAccessor->setValue($object, $name, $property);

        $this->pushResult($object);
    }

    public function visitElementStart($key)
    {
        parent::visitElementStart($key);

        $type = $this->peekType(1);

        if (preg_match('/^(.*)\\[\\]$/', $type, $matches)) {
            $elementType = $matches[1];
        } else {
            $elementType = null;
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
