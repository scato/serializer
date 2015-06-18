<?php

namespace Scato\Serializer\Debug;

use Scato\Serializer\Core\TypedVisitorInterface;

class EchoTypedVisitorDecorator implements TypedVisitorInterface
{
    private $parent;

    public function __construct(TypedVisitorInterface $parent)
    {
        $this->parent = $parent;
    }

    public function visitType($type)
    {
        $this->log('visitType', $type);
        $this->parent->visitType($type);
    }

    public function getResult()
    {
        return $this->parent->getResult();
    }

    public function visitObjectStart()
    {
        $this->log('visitObjectStart');
        $this->parent->visitObjectStart();
    }

    public function visitObjectEnd()
    {
        $this->log('visitObjectEnd');
        $this->parent->visitObjectEnd();
    }

    public function visitPropertyStart($name)
    {
        $this->log('visitPropertyStart', $name);
        $this->parent->visitPropertyStart($name);
    }

    public function visitPropertyEnd($name)
    {
        $this->log('visitPropertyEnd', $name);
        $this->parent->visitPropertyEnd($name);
    }

    public function visitArrayStart()
    {
        $this->log('visitArrayStart');
        $this->parent->visitArrayStart();
    }

    public function visitArrayEnd()
    {
        $this->log('visitArrayEnd');
        $this->parent->visitArrayEnd();
    }

    public function visitElementStart($key)
    {
        $this->log('visitElementStart', $key);
        $this->parent->visitElementStart($key);
    }

    public function visitElementEnd($key)
    {
        $this->log('visitElementEnd', $key);
        $this->parent->visitElementEnd($key);
    }

    public function visitValue($value)
    {
        $this->log('visitValue', $value);
        $this->parent->visitValue($value);
    }

    private function log($call, $param = '')
    {
        echo "$call($param)";
    }

}
