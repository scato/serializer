<?php

namespace Scato\Serializer\Json;

use Scato\Serializer\Common\TypeProviderInterface;
use Scato\Serializer\Core\ObjectAccessorInterface;
use Scato\Serializer\Core\TypedVisitorInterface;

class FromJsonVisitor extends ToJsonVisitor implements TypedVisitorInterface
{
    private $types = array();
    private $typeProvider;

    public function __construct(ObjectAccessorInterface $objectAccessor, TypeProviderInterface $typeProvider)
    {
        parent::__construct($objectAccessor);

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

        parent::visitPropertyEnd($name);
    }

    public function visitArrayStart()
    {
        parent::visitArrayStart();

        $type = $this->peekType(1);

        if (preg_match('/^(.*)\\[\\]$/', $type, $matches)) {
            $elementType = $matches[1];
        } else {
            $elementType = null;
        }

        $this->pushType($elementType);
    }

    public function visitArrayEnd()
    {
        $this->popType();

        parent::visitArrayEnd();
    }

    private function pushType($type)
    {
        array_push($this->types, $type);
    }

    private function peekType($count)
    {
        return $this->types[count($this->types) - $count];
    }

    private function popType()
    {
        return array_pop($this->types);
    }
}
