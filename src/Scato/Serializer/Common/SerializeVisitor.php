<?php


namespace Scato\Serializer\Common;

use LogicException;
use Scato\Serializer\Core\VisitorInterface;
use SplStack;

class SerializeVisitor implements VisitorInterface
{
    /**
     * @var SplStack
     */
    protected $results;

    public function __construct()
    {
        $this->results = new SplStack();
    }

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

    public function visitObjectStart()
    {
        $this->results->push(array());
    }

    public function visitObjectEnd()
    {
        $this->createObject();
    }

    public function visitPropertyStart($name)
    {
    }

    public function visitPropertyEnd($name)
    {
        $this->createElement($name);
    }

    public function visitArrayStart()
    {
        $this->results->push(array());
    }

    public function visitArrayEnd()
    {
    }

    public function visitElementStart($key)
    {
    }

    public function visitElementEnd($key)
    {
        $this->createElement($key);
    }

    public function visitValue($value)
    {
        $this->results->push($value);
    }

    protected function createObject()
    {
    }

    protected function createElement($key)
    {
        $element = $this->results->pop();
        $array = $this->results->pop();

        $array[$key] = $element;

        $this->results->push($array);
    }
}
