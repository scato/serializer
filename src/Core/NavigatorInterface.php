<?php

namespace Scato\Serializer\Core;

/**
 * Guides a Visitor through an object graph or data tree
 */
interface NavigatorInterface
{
    /**
     * @param NavigatorInterface $navigator
     * @param VisitorInterface   $visitor
     * @param mixed              $value
     * @return void
     */
    public function accept(NavigatorInterface $navigator, VisitorInterface $visitor, $value);
}
