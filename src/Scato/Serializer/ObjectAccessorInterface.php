<?php
namespace Scato\Serializer;

interface ObjectAccessorInterface
{
    public function getNames($object);
    public function getValue($object, $name);
    public function setValue($object, $name, $value);
}
