<?php


namespace Scato\Serializer\Navigation;

use LogicException;
use Scato\Serializer\Core\VisitorInterface;
use SplStack;

/**
 * Turns an object graph into a data tree
 *
 * All objects are transformed into associative arrays
 * All other values keep their original type
 *
 * A result stack is used to store temporary results while traversing the object graph
 */
class SerializeVisitor implements VisitorInterface
{
    /**
     * @var SplStack
     */
    protected $results;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->results = new SplStack();
    }

    /**
     * @return mixed
     * @throws LogicException
     */
    public function getResult()
    {
        if ($this->results->count() !== 1) {
            throw new LogicException(
                "The result stack should contain exactly one item when getResult() is called, it contains "
                . $this->results->count()
                . " results"
            );
        }

        return $this->results->pop();
    }

    /**
     * @return void
     */
    public function visitArrayStart()
    {
        $this->results->push(array());
    }

    /**
     * @return void
     */
    public function visitArrayEnd()
    {
        $this->createObject();
    }

    /**
     * @param integer|string $key
     * @return void
     */
    public function visitElementStart($key)
    {
    }

    /**
     * @param integer|string $key
     * @return void
     */
    public function visitElementEnd($key)
    {
        $this->createElement($key);
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function visitValue($value)
    {
        $this->results->push($value);
    }

    /**
     * Replace the top of the result stack with an object of the appropriate type
     *
     * @return void
     */
    protected function createObject()
    {
        // keep the array
    }

    /**
     * @param string $key
     * @return void
     */
    protected function createElement($key)
    {
        $element = $this->results->pop();
        $array = $this->results->pop();

        $array[$key] = $element;

        $this->results->push($array);
    }
}
