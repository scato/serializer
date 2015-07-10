<?php


namespace Scato\Serializer\Common;

use Scato\Serializer\Core\Type;
use Scato\Serializer\Core\TypedVisitorInterface;
use SplStack;

/**
 * Turns a data tree into an object graph
 *
 * All objects are transformed into another object of the appropriate type using an ObjectFactory
 * All other values keep their original type
 * For each property, the associated type should be provided by a TypeProvider
 * For each element of an array, the associated type is inferred using the type of its array
 *
 * Before visiting the root of the data tree, the associated type should be visited
 * A type stack is used to store the type associated with each part of the data tree
 */
class DeserializeVisitor extends SerializeVisitor implements TypedVisitorInterface
{
    /**
     * @var ObjectFactoryInterface
     */
    protected $objectFactory;

    /**
     * @var TypeProviderInterface
     */
    protected $typeProvider;

    /**
     * @var SplStack
     */
    protected $types;

    /**
     * @param ObjectFactoryInterface $objectFactory
     * @param TypeProviderInterface  $typeProvider
     */
    public function __construct(ObjectFactoryInterface $objectFactory, TypeProviderInterface $typeProvider)
    {
        parent::__construct();

        $this->types = new SplStack();

        $this->objectFactory = $objectFactory;
        $this->typeProvider = $typeProvider;
    }

    /**
     * @param Type $type
     * @return void
     */
    public function visitType(Type $type)
    {
        $this->types->push($type);
    }

    /**
     * @param string $name
     * @return void
     */
    public function visitPropertyStart($name)
    {
        parent::visitPropertyStart($name);

        $this->pushPropertyType($name);
    }

    /**
     * @param string $name
     * @return void
     */
    public function visitPropertyEnd($name)
    {
        $this->types->pop();

        parent::visitPropertyEnd($name);
    }

    /**
     * @param integer|string $key
     * @return void
     */
    public function visitElementStart($key)
    {
        parent::visitElementStart($key);

        $this->pushElementType($key);
    }

    /**
     * @param integer|string $key
     * @return void
     */
    public function visitElementEnd($key)
    {
        $this->types->pop();

        parent::visitElementEnd($key);
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    protected function createObject()
    {
        $type = $this->types->top();
        $array = $this->results->pop();

        $object = $this->objectFactory->createObject($type, $array);

        $this->results->push($object);
    }

    /**
     * Push the type corresponding to an element of an array on the top of the type stack
     *
     * @param integer|string $key
     * @return void
     */
    protected function pushElementType($key)
    {
        $type = $this->types->top();

        $this->types->push($type->getElementType());
    }

    /**
     * Push the type corresponding to a property on the top of the type stack
     *
     * @param string $name
     * @return void
     */
    protected function pushPropertyType($name)
    {
        $type = $this->types->top();

        $this->types->push($this->typeProvider->getType($type, $name));
    }
}
