<?php

namespace Scato\Serializer\Core;

/**
 * Operates on a data tree or object graph
 */
interface VisitorInterface
{
    /**
     * @return mixed
     */
    public function getResult();

    /**
     * @return void
     */
    public function visitArrayStart();

    /**
     * @return void
     */
    public function visitArrayEnd();

    /**
     * @param integer|string $key
     * @return void
     */
    public function visitElementStart($key);

    /**
     * @param integer|string $key
     * @return void
     */
    public function visitElementEnd($key);

    /**
     * @param mixed $value
     * @return void
     */
    public function visitValue($value);
}
