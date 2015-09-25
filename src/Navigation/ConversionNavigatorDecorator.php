<?php

namespace Scato\Serializer\Navigation;

use Scato\Serializer\Core\NavigatorInterface;
use Scato\Serializer\Core\VisitorInterface;

/**
 * Wraps around a Navigator, converting the input before passing it on
 */
class ConversionNavigatorDecorator implements NavigatorInterface
{
    /**
     * @var NavigatorInterface
     */
    private $navigator;

    /**
     * @var SerializationConverterInterface
     */
    private $converter;

    /**
     * @param NavigatorInterface              $navigator
     * @param SerializationConverterInterface $converter
     */
    public function __construct(NavigatorInterface $navigator, SerializationConverterInterface $converter)
    {
        $this->navigator = $navigator;
        $this->converter = $converter;
    }

    /**
     * @param NavigatorInterface $navigator
     * @param VisitorInterface   $visitor
     * @param mixed              $value
     * @return void
     */
    public function accept(NavigatorInterface $navigator, VisitorInterface $visitor, $value)
    {
        $this->navigator->accept($navigator, $visitor, $this->converter->convert($value));
    }
}
