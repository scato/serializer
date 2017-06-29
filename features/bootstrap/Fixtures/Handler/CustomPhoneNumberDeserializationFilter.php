<?php

namespace Fixtures\Handler;

use ReflectionClass;
use Scato\Serializer\Core\Type;
use Scato\Serializer\Navigation\DeserializationFilterInterface;
use Scato\Serializer\Navigation\ObjectFactoryInterface;

class CustomPhoneNumberDeserializationFilter implements DeserializationFilterInterface
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
        if ($type->toString() === '\Fixtures\Model\PhoneNumber') {
            $parameters = [$value['name'], $value['number']];

            return call_user_func_array(
                array(new ReflectionClass('\Fixtures\Model\PhoneNumber'), 'newInstance'),
                $parameters
            );
        }

        return $next->createObject($type, $value);
    }
}