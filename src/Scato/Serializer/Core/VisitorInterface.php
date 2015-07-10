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
    public function visitObjectStart();

    /**
     * @return void
     */
    public function visitObjectEnd();

    /**
     * @param string $name
     * @return void
     */
    public function visitPropertyStart($name);

    /**
     * @param string $name
     * @return void
     */
    public function visitPropertyEnd($name);

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
