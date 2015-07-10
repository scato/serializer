<?php

namespace Scato\Serializer\Core;

/**
 * Operates on a data tree or object graph that has a type associated with it
 */
interface TypedVisitorInterface extends VisitorInterface
{
    /**
     * @param Type $type
     * @return mixed
     */
    public function visitType(Type $type);
}
