<?php

namespace Fixtures\Handler;

use ReflectionClass;
use Scato\Serializer\Core\Type;
use Scato\Serializer\Navigation\DeserializationFilterInterface;
use Scato\Serializer\Navigation\ObjectFactoryInterface;
use SplDoublyLinkedList;

class CustomPersonDeserializationFilter implements DeserializationFilterInterface
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
        if ($type->toString() === '\Fixtures\Model\Person') {
            // replace array with list
            $array = $value['phoneNumbers'];
            $list = new SplDoublyLinkedList();
            foreach ($array as $k => $v) {
                $list->add($k, $v);
            }
            $value['phoneNumbers'] = $list;

            // construct instance using reflection
            $reflectionClass = new ReflectionClass('\Fixtures\Model\Person');
            $newInstance = $reflectionClass->newInstanceWithoutConstructor();
            foreach ($value as $name => $val) {
                $reflectionProperty = $reflectionClass->getProperty($name);
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($newInstance, $val);
            }
            return $newInstance;
        }

        return $next->createObject($type, $value);
    }
}