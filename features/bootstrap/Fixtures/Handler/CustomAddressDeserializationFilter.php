<?php

namespace Fixtures\Handler;

use ReflectionClass;
use Scato\Serializer\Core\Type;
use Scato\Serializer\Navigation\DeserializationFilterInterface;
use Scato\Serializer\Navigation\ObjectFactoryInterface;

class CustomAddressDeserializationFilter implements DeserializationFilterInterface
{
    /**
     * Handle object creation and return the object or value
     *
     * @param Type $type
     * @param mixed $value
     * @param ObjectFactoryInterface $next
     * @return mixed
     */
    public function filter(Type $type, $value, ObjectFactoryInterface $next)
    {
        if ($type->toString() === '\Fixtures\Model\Address') {
            $parameters = [$value['street'], $value['number'], $value['city']];

            return call_user_func_array(
                array(new ReflectionClass('\Fixtures\Model\Address'), 'newInstance'),
                $parameters
            );
        }

        return $next->createObject($type, $value);
    }
}