<?php


namespace Scato\Serializer\Common;

use LogicException;
use Scato\Serializer\Core\ObjectAccessorInterface;
use Scato\Serializer\Core\VisitorInterface;
use stdClass;

class ObjectToArrayVisitor implements VisitorInterface
{
    protected $objectAccessor;

    private $results = array();

    public function __construct(ObjectAccessorInterface $objectAccessor)
    {
        $this->objectAccessor = $objectAccessor;
    }

    public function getResult()
    {
        if (count($this->results) !== 1) {
            throw new LogicException(
                "The result stack should contain exactly one item when getResult() is called, it contains "
                . count($this->results)
                . " results"
            );
        }

        return array_pop($this->results);
    }

    public function visitObjectStart($class)
    {
        self::visitArrayStart();
    }

    public function visitObjectEnd($class)
    {
        self::visitArrayEnd();
    }

    public function visitPropertyStart($name)
    {
        self::visitElementStart($name);
    }

    public function visitPropertyEnd($name)
    {
        self::visitElementEnd($name);
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

    protected function pushResult($result)
    {
        array_push($this->results, $result);
    }

    protected function peekResult($count)
    {
        if (count($this->results) < $count) {
            throw new LogicException(
                "Cannot peek at number {$count} down the result stack, it only contains "
                . count($this->results)
                . " result(s)"
            );
        }

        return $this->results[count($this->results) - $count];
    }

    protected function popResult()
    {
        return array_pop($this->results);
    }
}
