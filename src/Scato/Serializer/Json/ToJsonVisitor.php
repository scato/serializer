<?php

namespace Scato\Serializer\Json;

use Scato\Serializer\Common\AbstractVisitor;
use Scato\Serializer\Core\ObjectAccessorInterface;
use stdClass;

class ToJsonVisitor extends AbstractVisitor
{
    protected $objectAccessor;

    public function __construct(ObjectAccessorInterface $objectAccessor)
    {
        $this->objectAccessor = $objectAccessor;
    }

    public function visitObjectStart($class)
    {
        $this->pushResult(new stdClass());
    }

    public function visitObjectEnd($class)
    {
    }

    public function visitPropertyStart($name)
    {
    }

    public function visitPropertyEnd($name)
    {
        $property = $this->popResult();
        $object = $this->popResult();

        $this->objectAccessor->setValue($object, $name, $property);

        $this->pushResult($object);
    }

    public function visitArrayStart()
    {
        $this->pushResult(array());
    }

    public function visitArrayEnd()
    {
    }

    public function visitElementStart($key)
    {
    }

    public function visitElementEnd($key)
    {
        $element = $this->popResult();
        $array = $this->popResult();

        $array[$key] = $element;

        $this->pushResult($array);
    }

    public function visitString($value)
    {
        $this->pushResult($value);
    }

    public function visitNull()
    {
        $this->pushResult(null);
    }

    public function visitNumber($value)
    {
        $this->pushResult($value);
    }

    public function visitBoolean($value)
    {
        $this->pushResult($value);
    }
}
