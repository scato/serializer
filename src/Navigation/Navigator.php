<?php

namespace Scato\Serializer\Navigation;

use Scato\Serializer\Core\NavigatorInterface;
use Scato\Serializer\Core\VisitorInterface;

/**
 * Guides a Visitor through an object graph or data tree
 *
 * Objects are handed to the Visitor as array
 * (this provides the most flexibility with the least complexity)
 */
class Navigator implements NavigatorInterface
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
                    $property = $this->objectAccessor->getValue($value, $name);
                    $visitor->visitElementStart($name);
                    $navigator->accept($navigator, $visitor, $property);
                    $visitor->visitElementEnd($name);
                }

                $visitor->visitArrayEnd();

                break;
            case 'array':
                $visitor->visitArrayStart();

                foreach ($value as $key => $element) {
                    $visitor->visitElementStart($key);
                    $navigator->accept($navigator, $visitor, $element);
                    $visitor->visitElementEnd($key);
                }

                $visitor->visitArrayEnd();

                break;
            default:
                $visitor->visitValue($value);

                break;
        }
    }
}
