<?php

namespace Scato\Serializer\Navigation;

use Scato\Serializer\Core\NavigatorInterface;
use Scato\Serializer\Core\VisitorInterface;

/**
 * Guides a Visitor through an object graph or data tree
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
     * @param VisitorInterface $visitor
     * @param mixed            $value
     * @return void
     */
    public function accept(VisitorInterface $visitor, $value)
    {
        switch (gettype($value)) {
            case 'object':
                $visitor->visitArrayStart();
                $names = $this->objectAccessor->getNames($value);

                foreach ($names as $name) {
                    $property = $this->objectAccessor->getValue($value, $name);
                    $visitor->visitElementStart($name);
                    $this->accept($visitor, $property);
                    $visitor->visitElementEnd($name);
                }

                $visitor->visitArrayEnd();

                break;
            case 'array':
                $visitor->visitArrayStart();

                foreach ($value as $key => $element) {
                    $visitor->visitElementStart($key);
                    $this->accept($visitor, $element);
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
