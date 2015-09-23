<?php

namespace Scato\Serializer\Xml;

use Scato\Serializer\Core\VisitorInterface;
use Scato\Serializer\Core\NavigatorInterface;
use Scato\Serializer\Navigation\ObjectAccessorInterface;

/**
 * Guides a Visitor through a DOMDocument
 */
class DOMNavigator implements NavigatorInterface
{
    /**
     * @var ObjectAccessorInterface
     */
    private $objectAccessor;

    /**
     * @param ObjectAccessorInterface $objectAccessor
     */
    public function __construct(ObjectAccessorInterface $objectAccessor)
    {
        $this->objectAccessor = $objectAccessor;
    }

    /**
     * @param NavigatorInterface $navigator
     * @param VisitorInterface   $visitor
     * @param mixed              $value
     * @return void
     */
    public function accept(NavigatorInterface $navigator, VisitorInterface $visitor, $value)
    {
        switch (gettype($value)) {
            case 'object':
                $visitor->visitArrayStart();
                $names = $this->objectAccessor->getNames($value);

                foreach ($names as $name) {
                    $properties = $this->objectAccessor->getValue($value, $name);

                    foreach ($properties as $property) {
                        $visitor->visitElementStart($name);
                        $navigator->accept($navigator, $visitor, $property);
                        $visitor->visitElementEnd($name);
                    }
                }

                $visitor->visitArrayEnd();

                break;
            default:
                $visitor->visitValue($value);

                break;
        }
    }
}
