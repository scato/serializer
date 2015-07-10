<?php

namespace Scato\Serializer\Core;

/**
 * Guides a Visitor through an object graph or data tree
 */
class Navigator
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
                    $property = $this->objectAccessor->getValue($value, $name);
                    $visitor->visitPropertyStart($name);
                    $this->accept($visitor, $property);
                    $visitor->visitPropertyEnd($name);
                }

                $visitor->visitObjectEnd();

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
