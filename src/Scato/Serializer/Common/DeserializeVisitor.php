<?php


namespace Scato\Serializer\Common;

use InvalidArgumentException;
use Scato\Serializer\Core\TypedVisitorInterface;
use SplStack;

class DeserializeVisitor extends SerializeVisitor implements TypedVisitorInterface
{
    protected $objectFactory;
    protected $typeProvider;

    protected $types;

    public function __construct(ObjectFactoryInterface $objectFactory, TypeProviderInterface $typeProvider)
    {
        parent::__construct();

        $this->types = new SplStack();

        $this->objectFactory = $objectFactory;
        $this->typeProvider = $typeProvider;
    }

    public function visitType($type)
    {
        $this->types->push($type);
    }

    public function visitPropertyStart($name)
    {
        parent::visitPropertyStart($name);

        $this->pushPropertyType($name);
    }

    public function visitPropertyEnd($name)
    {
        $this->types->pop();

        parent::visitPropertyEnd($name);
    }

    public function visitElementStart($key)
    {
        parent::visitElementStart($key);

        $this->pushElementType($key);
    }

    public function visitElementEnd($key)
    {
        $this->types->pop();

        parent::visitElementEnd($key);
    }

    protected function createObject()
    {
        $type = $this->types->top();
        $array = $this->results->pop();

        if ($type === null) {
            throw new InvalidArgumentException('Cannot create object because its type is unknown');
        }

        $object = $this->objectFactory->createObject($type, $array);

        $this->results->push($object);
    }

    protected function pushElementType($key)
    {
        $type = $this->types->top();

        if (preg_match('/\\[\\]$/', $type)) {
            $this->types->push(preg_replace('/\\[\\]$/', '', $type));
        } else {
            $this->types->push(null);
        }
    }

    protected function pushPropertyType($name)
    {
        $type = $this->types->top();

        $this->types->push($this->typeProvider->getType($type, $name));
    }
}
