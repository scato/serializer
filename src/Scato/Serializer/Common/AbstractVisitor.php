<?php


namespace Scato\Serializer\Common;

use LogicException;
use Scato\Serializer\Core\VisitorInterface;

abstract class AbstractVisitor implements VisitorInterface
{
    private $results = array();

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
