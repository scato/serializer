<?php

namespace Scato\Serializer\Debug;

use Scato\Serializer\Core\Type;
use Scato\Serializer\Core\TypedVisitorInterface;

/**
 * Decorates a TypedVisitor, echoing every call that is made
 */
class EchoTypedVisitorDecorator implements TypedVisitorInterface
{
    /**
     * The TypedVisitor that is decorated
     *
     * @var TypedVisitorInterface
     */
    private $parent;

    /**
     * @param TypedVisitorInterface $parent
     */
    public function __construct(TypedVisitorInterface $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @param Type $type
     * @return void
     */
    public function visitType(Type $type)
    {
        $this->log('visitType', $type);
        $this->parent->visitType($type);
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->parent->getResult();
    }

    /**
     * @return void
     */
    public function visitObjectStart()
    {
        $this->log('visitObjectStart');
        $this->parent->visitObjectStart();
    }

    /**
     * @return void
     */
    public function visitObjectEnd()
    {
        $this->log('visitObjectEnd');
        $this->parent->visitObjectEnd();
    }

    /**
     * @param string $name
     * @return void
     */
    public function visitPropertyStart($name)
    {
        $this->log('visitPropertyStart', $name);
        $this->parent->visitPropertyStart($name);
    }

    /**
     * @param string $name
     * @return void
     */
    public function visitPropertyEnd($name)
    {
        $this->log('visitPropertyEnd', $name);
        $this->parent->visitPropertyEnd($name);
    }

    /**
     * @return void
     */
    public function visitArrayStart()
    {
        $this->log('visitArrayStart');
        $this->parent->visitArrayStart();
    }

    /**
     * @return void
     */
    public function visitArrayEnd()
    {
        $this->log('visitArrayEnd');
        $this->parent->visitArrayEnd();
    }

    /**
     * @param integer|string $key
     * @return void
     */
    public function visitElementStart($key)
    {
        $this->log('visitElementStart', $key);
        $this->parent->visitElementStart($key);
    }

    /**
     * @param integer|string $key
     * @return void
     */
    public function visitElementEnd($key)
    {
        $this->log('visitElementEnd', $key);
        $this->parent->visitElementEnd($key);
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function visitValue($value)
    {
        $this->log('visitValue', $value);
        $this->parent->visitValue($value);
    }

    /**
     * @param string $call
     * @param string $param
     * @return void
     */
    private function log($call, $param = '')
    {
        echo "$call($param)";
    }
}
