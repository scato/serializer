<?php

namespace Scato\Serializer\Navigation;

use Scato\Serializer\Core\NavigatorInterface;
use Scato\Serializer\Core\VisitorInterface;

/**
 * Wraps around a Navigator, transforming the input before passing it on
 */
class FilterNavigatorDecorator implements NavigatorInterface
{
    /**
     * @var NavigatorInterface
     */
    private $navigator;

    /**
     * @var FilterInterface
     */
    private $filter;

    /**
     * @param NavigatorInterface $navigator
     * @param FilterInterface    $filter
     */
    public function __construct(NavigatorInterface $navigator, FilterInterface $filter)
    {
        $this->navigator = $navigator;
        $this->filter = $filter;
    }

    /**
     * @param NavigatorInterface $navigator
     * @param VisitorInterface   $visitor
     * @param mixed              $value
     * @return void
     */
    public function accept(NavigatorInterface $navigator, VisitorInterface $visitor, $value)
    {
        $this->navigator->accept($navigator, $visitor, $this->filter->filter($value));
    }
}
