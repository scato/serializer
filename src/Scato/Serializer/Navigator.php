<?php

namespace Scato\Serializer;

class Navigator
{
    private $objectAccessor;

    public function __construct(ObjectAccessorInterface $objectAccessor)
    {
        $this->objectAccessor = $objectAccessor;
    }

    public function accept(ValueVisitorInterface $visitor, $value)
    {
        switch (gettype($value)) {
            case 'object':
                $visitor->visitObjectStart(get_class($value));
                $names = $this->objectAccessor->getNames($value);

                foreach ($names as $name) {
                    $property = $this->objectAccessor->getValue($value, $name);
                    $visitor->visitPropertyStart($name);
                    $this->accept($visitor, $property);
                    $visitor->visitPropertyEnd($name);
                }

                $visitor->visitObjectEnd(get_class($value));

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
            case 'string':
                $visitor->visitString($value);

                break;
            case 'NULL':
                $visitor->visitNull();

                break;
            case 'boolean':
                $visitor->visitBoolean($value);

                break;
            default:
                if (is_numeric($value)) {
                    $visitor->visitNumber($value);

                    break;
                }

                throw new \InvalidArgumentException('Cannot accept a value of type ' . gettype($value));
        }
    }
}
