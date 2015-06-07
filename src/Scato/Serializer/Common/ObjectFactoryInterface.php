<?php
namespace Scato\Serializer\Common;

interface ObjectFactoryInterface
{
    public function createObject($class, $properties);
}
