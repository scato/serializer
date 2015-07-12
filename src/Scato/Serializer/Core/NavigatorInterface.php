<?php

namespace Scato\Serializer\Core;

/**
 * Guides a Visitor through an object graph or data tree
 */
interface NavigatorInterface
{
    /**
     * @param VisitorInterface $visitor
     * @param mixed $value
     * @return void
     */
    public function accept(VisitorInterface $visitor, $value);
}
