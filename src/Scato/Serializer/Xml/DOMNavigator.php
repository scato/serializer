<?php

namespace Scato\Serializer\Xml;

use Scato\Serializer\Core\Navigator;
use Scato\Serializer\Core\ObjectAccessorInterface;
use Scato\Serializer\Core\VisitorInterface;

class DOMNavigator extends Navigator
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
                $visitor->visitObjectStart();
                $names = $this->objectAccessor->getNames($value);

                foreach ($names as $name) {
                    $properties = $this->objectAccessor->getValue($value, $name);

                    foreach ($properties as $property) {
                        $visitor->visitPropertyStart($name);
                        $this->accept($visitor, $property);
                        $visitor->visitPropertyEnd($name);
                    }
                }

                $visitor->visitObjectEnd();

                break;
            default:
                $visitor->visitValue($value);

                break;
        }
    }
}
