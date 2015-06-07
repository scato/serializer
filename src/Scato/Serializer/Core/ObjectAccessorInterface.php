<?php
namespace Scato\Serializer\Core;

interface ObjectAccessorInterface
{
    public function getNames($object);
    public function getValue($object, $name);
}
